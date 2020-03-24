<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\User;
use App\Services\ACLService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/*
 * роли ищутся по слагу
 * */

class RoleController extends Controller
{
    use SoftDeletes;
    protected $ACLService;
    protected $userService;

    public function __construct(Request $request, ACLService $ACLService, UserService $userService)
    {
        $this->ACLService = $ACLService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // перенаправляет назад при неудаче или выдает json ошибку при ajax
        $vd = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        // прошли валидацию, сохраняем модель в базу
        $role = new Role();
        $role->fill($request->all());
        if (!$role->save()) {
            return redirect()->back()->withErrors('Не удалось сохранение')->withInput();
        }

        // редирект route('permission.index')
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissionArr = $this->ACLService->getPermissionSelect();
        $rolePermissions = $role->getPermissions();
        //dd($rolePermissions);

        return view('admin.role.edit', compact('role', 'permissionArr', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        // перенаправляет назад при неудаче или выдает json ошибку при ajax
        $vd = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);
        $role = Role::find($role_id);
        // прошли валидацию, сохраняем модель в базу
        $role->fill($request->except('slug'));
        if (!$role->save()) {
            return redirect()->back()->withErrors('Не удалось сохранение')->withInput();
        }
        // redirect
        return redirect()->route('role.edit', ['id' => $role->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index');
    }

    public function assignRole(Request $request, User $user)
    {
        $role = Role::find($request->input('role'));
        if (!$this->userService->addUserRoleBySlug($user, $role->slug)) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

    public function revokeRole(Request $request, $user_id, $role_id)
    {
        $user = User::find($user_id);
        $role = Role::find($role_id);
        if ((!$role) || (!$user)) {
            return redirect()->back()->withErrors('Неправильные параметры')->withInput();
        }
        if (!$user->hasRole($role->slug)) {
            return redirect()->back()->withErrors('Роль не привязана')->withInput();
        } else {
            $user->revokeRole($role->slug);
        }
        return redirect()->back();
    }

    public function addPermission(Request $request, Role $role)
    {
        //dd($request->all());
        $vd = $request->validate([
            'permission_id' => 'required',
        ]);
        $permission_id = $request->input('permission_id');

        $role->assignPermission($permission_id);

        return redirect()->back();
    }

    public function revokePermission(Request $request, $role_id, $permission_id)
    {
        $role = Role::find($role_id);
        $permission = Permission::where('name', $permission_id)->first();
        if ((!$role) || (!$permission)) {
            return redirect()->back()->withErrors('Неправильные параметры')->withInput();
        }

        $role->revokePermission($permission->id);
        return redirect()->back();
    }
}
