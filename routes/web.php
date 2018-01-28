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

Route::get('/', function () {
    $projects = App\Project::all();
    return view('welcome')
        ->with('projects', $projects);
});

Route::resource('project', 'ProjectController');
Route::post('project/comment', 'ProjectController@comment')->name('project.comment');
Route::get('project/{project}/readme', 'ProjectController@readme')->name('project.readme');
Route::resource('projectuser', 'ProjectUserController');
Route::resource('task', 'TaskController');
Route::post('task/comment', 'TaskController@comment')->name('task.comment');
Route::patch('task/{task}/status', 'TaskController@updateStatus')->name('task.status');
Route::resource('release', 'ReleaseController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/file/{file}', 'FileController@show')->name('file.show');
Route::get('file/{file}/download', 'FileController@download')->name('file.download');

// admin
Route::get('/admin/users', 'UserController@list')->middleware('bouncer:admin');
Route::get('/admin/users/addRole', 'UserController@addRole')->middleware('bouncer:admin');
Route::get('/admin/users/removeRole', 'UserController@removeRole')->middleware('bouncer:admin');