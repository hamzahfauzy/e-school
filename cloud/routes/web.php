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

Route::middleware('allowed')->group(function(){
	Route::get('/', function () {
	    return view('index');
	});

	Route::get('files','FileController@index');
	Route::get('files/{folder}','FileController@index');

	Route::get('shared-file','FileController@share');
});
