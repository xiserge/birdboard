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
    return view('home');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('projects/create', 'ProjectsController@create');
    Route::get('projects', 'ProjectsController@index');
    Route::post('projects', 'ProjectsController@store');
    Route::get('projects/{project}', 'ProjectsController@view');

    Route::post('projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('projects/{project}/tasks/{task}', 'ProjectTasksController@update');
});

Auth::routes();
