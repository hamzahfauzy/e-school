<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('student')->group(function(){
    Route::get('','API\StudentController@index');
    Route::get('{ID}','API\StudentController@single');
    Route::post('create','API\StudentController@create');
    Route::post('update','API\StudentController@update');
    Route::delete('delete','API\StudentController@delete');
});

Route::prefix('study')->group(function(){
    Route::get('','API\StudyController@index');
    Route::get('{ID}','API\StudyController@single');
    Route::post('create','API\StudyController@create');
    Route::post('update','API\StudyController@update');
    Route::delete('delete','API\StudyController@delete');
});

Route::prefix('major')->group(function(){
    Route::get('','API\MajorController@index');
    Route::get('{ID}','API\MajorController@single');
    Route::post('create','API\MajorController@create');
    Route::post('update','API\MajorController@update');
    Route::delete('delete','API\MajorController@delete');
});

Route::prefix('employee')->group(function(){
    Route::get('','API\EmployeeController@index');
    Route::get('{ID}','API\EmployeeController@single');
    Route::post('create','API\EmployeeController@create');
    Route::post('update','API\EmployeeController@update');
    Route::delete('delete','API\EmployeeController@delete');
});

Route::prefix('schedule')->group(function(){
    Route::get('','API\ScheduleController@index');
    Route::get('{ID}','API\ScheduleController@single');
    Route::post('create','API\ScheduleController@create');
    Route::post('update','API\ScheduleController@update');
    Route::delete('delete','API\ScheduleController@delete');
});

Route::prefix('class_room')->group(function(){
    Route::get('','API\ClassRoomController@index');
    Route::get('{ID}','API\ClassRoomController@single');
    Route::post('create','API\ClassRoomController@create');
    Route::post('update','API\ClassRoomController@update');
    Route::delete('delete','API\ClassRoomController@delete');
});