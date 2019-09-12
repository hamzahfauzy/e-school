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
Route::get('/','HomeController@index');
Route::get('/class_rooms','HomeController@class_rooms');
Route::get('/employees','HomeController@employees');
Route::get('/majors','HomeController@majors');
Route::get('/schedules','HomeController@schedules');
Route::get('/students','HomeController@students');
Route::get('/users','HomeController@users');
