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


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('projects', 'ProjectsController@index');
Route::post('projects', 'ProjectsController@store')->middleware('auth');

Route::get('projects/{project}', 'ProjectsController@view');

Route::get('test', function(){
    echo date('Y-m-d H-i-s');
});

Auth::routes();
