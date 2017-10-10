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
Route::resource('task', 'TaskController');
Route::resource('release', 'ReleaseController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
