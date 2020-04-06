<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Test;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->flash();

        $newUser = $this->userService->createNewUser(
            $request->input('email'),
            $request->input('password'),
            ['name' => $request->input('name')]
        );
        if ($newUser === null) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $availableRoles = FormatHelper::getObjectsCollectionFormSelectData(Role::all(), 'id', 'name');
        $availableTests = FormatHelper::getObjectsCollectionFormSelectData(Test::all(), 'id', 'title');
        return view('admin.users.show', compact('user', 'availableRoles', 'availableTests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$this->userService->updateUser($user, $request->all())) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('Удаление не реализовано', $id);
    }


    public function setPassword(Request $request, User $user)
    {
        if (!$this->userService->setConfirmedPassword($user, $request->input('password'))) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

    public function addRole(Request $request, User $user)
    {
        if (!$this->userService->addUserRoleById($user, $request->input('role_id'))) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

    public function removeRole(Request $request, User $user, $slug)
    {
        if (!$this->userService->removeUserRoleBySlug($user, $slug)) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

    public function assignTest(Request $request, User $user)
    {
        if (!$this->userService->assignTest($user, $request->input('test_id'))) {
            return redirect()->back()->withErrors($this->userService->getServiceErrors());
        }
        return redirect()->back();
    }

}
