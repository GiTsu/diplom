<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clearcache', function (Request $request) {
    if (!empty(request()) && request()->has('diplom')) {
        //Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        //Artisan::call('backup:clean');
        return "Кэш очищен";
    } else {
        return 'clean complete';
    }

});


/*
 * Самое сокровенное, для суперадмина
 * */
Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['auth'], //, 'acl' - пока проверка только на авторизацию
    //'is' => 'superadmin',
], function () {
    /* Контроллеры доступа ACL, роли и пермишены */
    Route::resource('/role', 'ACL\RoleController');
    Route::resource('/permission', 'ACL\PermissionController');

    // users
    Route::resource('/user', 'UsersController');

    // permissions
    Route::post('/permission/addslug/{permission}', 'ACL\PermissionController@addSlug')->name('permission:addslug');
    Route::get('/permission/removeslug/{permission}/{slug}',
        'ACL\PermissionController@removeSlug')->name('permission:removeslug');
    Route::post('/role/addpermission/{role}', 'ACL\RoleController@addPermission')->name('role:addperm');
    Route::get('/role/revokepermission/{role}/{permission}',
        'ACL\RoleController@revokePermission')->name('role:revokeperm');
    Route::post('/role/assign/{user}', 'ACL\RoleController@assignRole')->name('role:assign');
    Route::get('/role/revoke/{user}/{role}', 'ACL\RoleController@revokeRole')->name('role:revoke');
});


Route::get('admin', 'Admin\DefaultController@index')->name('admin:default:index');

Route::resource('admin/tests', 'Admin\TestsController');
Route::resource('admin/questions', 'Admin\QuestionsController');

Auth::routes(['register' => false]); //  нет автоматической регистрации

Route::get('/', 'HomeController@index')->name('site:index');

Route::get('/home', 'HomeController@home')->name('home');




