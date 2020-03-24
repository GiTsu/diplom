<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Models\CustomPermission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kodeine\Acl\Models\Eloquent\Permission;

class UserPermissionsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

//    dd(CustomPermission::find(1)->slug);
    $user = User::find($request->user);

    $data = [
      'dataPageTitle' => [
        'title' => 'Permissions значение кешируется тоесть не сразу наступает',
        'button' => [
          'title' => 'Добавить доступ',
          'ti-icon' => 'ti-plus',
//            'route' => ''
        ]
      ],
      'user' => $user,
      'userPermissions' => $user->getPermissions(),
      'customPermissions' => CustomPermission::all()
    ];
    return view('admin.userPermissions.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return void
     */
  public function store(Request $request, User $user)
  {
    dd($user);
  }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
  public function show($id)
  {

  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return void
     */
  public function edit(User $user)
  {
    //
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
  {
      $user = User::find($id);
    if (Auth::user()->can('update.user')) {
      $permissions = [];
      $oldPrem = $user->getPermissions();
      $newPerm = $request->get($request->permissions);

      foreach ($oldPrem[$request->permissions] as $key => $value) {
        $permissions[$key] = isset($newPerm[$key]) ? true : false;
      };

      $user->addPermission($request->permissions, $permissions);
    }
    return redirect()->route('user-permissions.index', ['user' => $user]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
}
