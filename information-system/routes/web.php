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
    Route::get('/','HomeController@index');
    Route::get('/class_rooms','HomeController@class_rooms');
    Route::get('/class_rooms/{name}','HomeController@class_room');
    Route::get('/employees','HomeController@employees');
    Route::get('/employees/{name}','HomeController@employee');
    Route::get('/majors','HomeController@majors');
    Route::get('/studies','HomeController@studies');
    Route::get('/students','HomeController@students');
    Route::get('/users','HomeController@users');
    Route::get('/schedules','HomeController@schedules');
});
