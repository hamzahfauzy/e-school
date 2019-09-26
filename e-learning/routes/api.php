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

Route::middleware('auth:api')->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    
});

Route::prefix('announcement')->group(function(){
    Route::get('','API\AnnouncementController@index');
    Route::get('{ID}','API\AnnouncementController@single');
    Route::post('create','API\AnnouncementController@create');
    Route::post('update','API\AnnouncementController@update');
    Route::delete('delete','API\AnnouncementController@delete');
});