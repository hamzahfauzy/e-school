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

Route::prefix('folder')->group(function(){
	Route::post('/','API\FolderController@index');
	Route::post('create','API\FolderController@create');
	Route::delete('delete','API\FolderController@delete');
});

Route::prefix('files')->group(function(){
	Route::post('all','API\FileController@all');
	Route::get('{id}','API\FileController@single');
	Route::post('index/{folder}','API\FileController@index');
	Route::post('upload','API\FileController@upload');
	Route::post('share','API\FileController@share');
	Route::delete('delete','API\FileController@delete');
});

Route::prefix('share')->group(function(){
	Route::post('','API\ShareFileController@index');
});