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