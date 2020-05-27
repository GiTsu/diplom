<?php

// открытый доступ
Auth::routes(['register' => false]); //  нет автоматической регистрации
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
// очистка кеша, реально происходит с параметром ?diplom
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
 * Доступ авторизованного пользователя
 * */
Route::group([
    //'prefix' => '/admin',
    //'namespace' => 'Admin',
    'middleware' => ['auth'], //, 'acl' - пока проверка только на авторизацию
    //'is' => 'superadmin',
], function () {
    Route::get('/', 'HomeController@index')->name('site:index');
    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/examTest/{result}/', 'HomeController@examTest')->name('test:next');
    Route::post('/answerTest/{result}/', 'HomeController@examTestAnswer')->name('test:answer');
});


/*
 * Самое сокровенное, для суперадмина
 * */
Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'acl'],
    'is' => 'teacher|admin',
], function () {
    // главная
    Route::get('/', 'DefaultController@index')->name('admin:default:index');

    Route::get('/results', 'ResultsController@index')->name('admin:results:index');
    Route::post('/results/test/{test}/assignGroup', 'ResultsController@assignToGroup')->name('admin:results:assignToGroup');
    Route::get('/results/user/{user}/assignTest/{test}', 'ResultsController@assignToUser')->name('admin:results:retest');


    Route::resource('/groups', 'GroupsController');
    Route::get('/groups/dismiss/{user}', 'GroupsController@dismiss')->name('admin:groups:dismiss');

    Route::resource('/subjects', 'SubjectsController');
    // тесты и вопросы
    Route::resource('/tests', 'TestsController');
    Route::get('/tests/evaluate/{result}/result', 'TestsController@showEvaluate')->name('test:showEvaluate');
    Route::put('/tests/evaluate/{result}/result', 'TestsController@putEvaluate')->name('test:putEvaluate');
    Route::resource('/questions', 'QuestionsController');
    Route::post('/questions/linkTest', 'QuestionsController@linkTest')->name('question:linkTest');


    Route::resource('/questionItems', 'QuestionItemsController');
    Route::get('/questionItems/{questionItem}/toggle', 'QuestionItemsController@toggleCorrect')->name('admin:questionItems:toggle');

    Route::post('/questions/{questionItem}/link', 'QuestionItemsController@linkQuestions')->name('questions:link');
    Route::get('/questions/{questionItem}/unlink', 'QuestionsController@unlinkTest')->name('questions:unlink');
    Route::post('/question/{question}/assignTest', 'QuestionsController@assignTest')->name('question:assignTest');




    /* Контроллеры доступа ACL, роли и пермишены */
    // resources
    Route::resource('/user', 'UsersController');
    Route::resource('/role', 'ACL\RoleController');
    Route::resource('/permission', 'ACL\PermissionController');

    // manage user
    Route::post('/user/{user}/setPassword', 'UsersController@setPassword')->name('user:setPassword');
    Route::post('/user/{user}/addRole', 'UsersController@addRole')->name('user:addRole');
    Route::post('/user/{user}/setGroup', 'UsersController@setGroup')->name('user:setGroup');

    Route::get('/user/{user}/removeRole/{slug}', 'UsersController@removeRole')->name('user:removeRole');
    Route::post('/user/{user}/assignTest', 'UsersController@assignTest')->name('user:assignTest');

    // manage acl
    Route::post('/permission/addslug/{permission}', 'ACL\PermissionController@addSlug')->name('permission:addslug');
    Route::get('/permission/removeslug/{permission}/{slug}',
        'ACL\PermissionController@removeSlug')->name('permission:removeslug');
    Route::post('/role/addpermission/{role}', 'ACL\RoleController@addPermission')->name('role:addperm');
    Route::get('/role/revokepermission/{role}/{permission}',
        'ACL\RoleController@revokePermission')->name('role:revokeperm');
    //Route::post('/role/assign/{user}', 'ACL\RoleController@assignRole')->name('role:assign');
    //Route::get('/role/revoke/{user}/{role}', 'ACL\RoleController@revokeRole')->name('role:revoke');

});













