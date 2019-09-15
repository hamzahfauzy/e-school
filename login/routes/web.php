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

// Auth::routes();
Route::get('login','MainController@login')->name('login');
Route::get('/','MainController@index')->name('index');
Route::middleware('allowed')->group(function(){
	Route::get('dashboard',function(){
	    return view('dashboard');
	});
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/users', 'UserController@index')->name('users');
	Route::get('/roles', 'RoleController@index')->name('roles');
	Route::get('/application_portals', 'ApplicationPortalController@index')->name('application_portals');
	Route::get('/cloud_setting', 'CloudSettingController@index')->name('cloud_setting');
});
