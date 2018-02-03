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

Auth::routes();

Route::middleware(['bouncer:user'])->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('project', 'ProjectController');
    Route::post('project/comment', 'ProjectController@comment')->name('project.comment');
    Route::get('project/{project}/readme', 'ProjectController@readme')->name('project.readme');
    Route::resource('projectuser', 'ProjectUserController');
    Route::resource('task', 'TaskController');
    Route::post('task/comment', 'TaskController@comment')->name('task.comment');
    Route::patch('task/{task}/status', 'TaskController@updateStatus')->name('task.status');
    Route::post('task/{task}/assign', 'TaskController@assign')->name('task.assign');
    Route::resource('release', 'ReleaseController');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/file/{file}', 'FileController@show')->name('file.show');
    Route::get('file/{file}/download', 'FileController@download')->name('file.download');
});

// admin
Route::middleware(['bouncer:admin'])->group(function () {
    Route::get('/admin/users', 'UserController@list');
    Route::get('/admin/users/addRole', 'UserController@addRole');
    Route::get('/admin/users/removeRole', 'UserController@removeRole');
});