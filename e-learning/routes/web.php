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
	Route::get('assignments','HomeController@assignment');
	Route::get('questions','HomeController@question');
	Route::get('questions/{question}','HomeController@showQuestion');
	Route::get('exams','HomeController@exam');
	Route::get('exams/{exam}','HomeController@showExam');
	Route::get('virtual-classroom','HomeController@virtualClassroom');
	Route::get('virtual-classroom/start/{virtualClassroom}','HomeController@startVirtualClassroom');
	Route::get('virtual-classroom/finish/{virtualClassroom}','HomeController@finishVirtualClassroom');
	Route::get('virtual-classroom/{virtualClassroom}','HomeController@showVirtualClassroom');
});
