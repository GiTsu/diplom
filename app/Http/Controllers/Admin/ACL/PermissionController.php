<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\ACLService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use SoftDeletes;
    protected $ACLService;

    public function __construct(Request $request, ACLService $ACLService)
    {
        $this->ACLService = $ACLService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = Permission::get();
        return view('admin.permission.index', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // перенаправляет назад при неудаче или выдает json ошибку при ajax
        $vd = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // прошли валидацию, сохраняем модель в базу
        $permission = new Permission();
        $permission->fill($request->all());
        $permission->slug = [];
        if (!$permission->save()) {
            return redirect()->back()->withErrors('Не удалось сохранение')->withInput();
        }

        // редирект route('permission.index')
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('admin.permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $permissionArr = $this->ACLService->getPermissionSelect();

        return view('admin.permission.edit', compact('permission', 'permissionArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        // перенаправляет назад при неудаче или выдает json ошибку при ajax
        $vd = $request->validate([
            'name' => 'required',
        ]);

        // прошли валидацию, сохраняем модель в базу
        $permission->fill($request->except('slug'));
        $temp = $permission->slug;
        foreach ($temp as $key => $value) {
            if (array_key_exists($key, $request->input('slug'))) {
                $temp[$key] = true;
            } else {
                $temp[$key] = false;
            }
        }

        $permission->slug = $temp;
        if (!$permission->save()) {
            return redirect()->back()->withErrors('Не удалось сохранение')->withInput();
        }
        // redirect
        return redirect()->route('permission.edit', ['id' => $permission->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permission.index');
    }

    public function addSlug(Request $request, Permission $permission)
    {
        // прямое измеение массива после cast вызывает варнинг, читаем и устанавливаем аксесорами
        $slug = $permission->slug;
        $key = $request->input('key');
        $slug[$key] = false;
        $permission->slug = $slug;
        $permission->save();

        return redirect()->back();
    }

    public function removeSlug(Request $request, Permission $permission, $slug)
    {
        $temp = $permission->slug;
        if (isset($temp[$slug])) {
            //unset($temp[$slug]); не работает)
            // нужно для функции setSlugAttribute в родительском классе
            $temp[$slug] = null;
        }

        $permission->slug = $temp;

        if (!$permission->save()) {
            return redirect()->back()->withErrors('Не удалось сохранение')->withInput();
        }
        return redirect()->back();
    }
}
