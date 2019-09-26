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
	    return view('index',[
	    	'role_id' => session('role_id')
	    ]);
	});

	Route::get('announcements','HomeController@announcement');
});
