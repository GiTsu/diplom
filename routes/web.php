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
Route::get('admin', 'Admin\DefaultController@index')->name('admin:default:index');

Route::resource('admin/tests', 'Admin\TestsController');
Route::resource('admin/questions', 'Admin\QuestionsController');

Auth::routes(['register' => false]); //  нет автоматической регистрации

Route::get('/', 'HomeController@index')->name('site:index');

Route::get('/home', 'HomeController@home')->name('home');




