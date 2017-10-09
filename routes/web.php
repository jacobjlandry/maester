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
/** Created by CRUDley at 2017-10-05 05:18:48 **/
Route::resource('task', 'TaskController');
/** Created by CRUDley at 2017-10-09 02:32:52 **/
Route::resource('release', 'ReleaseController');
/** Created by CRUDley at 2017-10-09 02:49:00 **/