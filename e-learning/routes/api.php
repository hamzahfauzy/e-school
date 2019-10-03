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
    Route::get('{teacher_id}','API\AnnouncementController@index');
    Route::get('get/{ID}','API\AnnouncementController@single');
    Route::get('get-by-classroom/{classroom}','API\AnnouncementController@getByClassroom');
    Route::post('create','API\AnnouncementController@create');
    Route::post('update','API\AnnouncementController@update');
    Route::delete('delete','API\AnnouncementController@delete');
});

Route::prefix('assignment-answer')->group(function(){
    Route::get('{student_id}','API\AssignmentAnswerController@get');
    Route::post('create','API\AssignmentAnswerController@create');
});

Route::prefix('assignment')->group(function(){
    Route::get('{teacher_id}','API\AssignmentController@index');
    Route::get('get/{ID}','API\AssignmentController@single');
    Route::get('get-answers/{assignment}','API\AssignmentController@get');
    Route::post('create','API\AssignmentController@create');
    Route::post('update','API\AssignmentController@update');
    Route::delete('delete','API\AssignmentController@delete');
});

Route::prefix('question')->group(function(){
    Route::get('{teacher_id}','API\QuestionController@index');
    Route::get('get/{ID}','API\QuestionController@single');
    Route::post('set-correct-answer','API\QuestionController@setCorrectAnswer');
    Route::post('create','API\QuestionController@create');
    Route::post('update','API\QuestionController@update');
    Route::delete('delete','API\QuestionController@delete');
});

Route::prefix('exam')->group(function(){
    Route::get('{teacher_id}','API\ExamController@index');
    Route::get('get/{ID}','API\ExamController@single');
    Route::get('get-with-students/{ID}','API\ExamController@singleWithStudents');
    Route::get('get/{ID}/answers/{student_id}','API\ExamController@answers');
    Route::get('get-status/{ID}/answers/{student_id}','API\ExamController@getStatus');
    Route::post('get-student-answer','API\ExamController@getStudentAnswer');
    Route::post('get-student-total-score','API\ExamController@getStudentTotalScore');
    Route::post('set-student-score','API\ExamController@setStudentScore');
    Route::post('finish','API\ExamController@setStatus');
    Route::post('create','API\ExamController@create');
    Route::post('update','API\ExamController@update');
    Route::delete('delete','API\ExamController@delete');
});

Route::prefix('exam_item')->group(function(){
    Route::get('{exam_id}','API\ExamItemController@index');
    Route::get('get/{ID}','API\ExamItemController@single');
    Route::post('answer','API\ExamItemController@answer');
    Route::post('create','API\ExamItemController@create');
    Route::post('update','API\ExamItemController@update');
    Route::delete('delete','API\ExamItemController@delete');
});

Route::prefix('answer')->group(function(){
    Route::get('{question_id}','API\AnswerController@index');
    Route::get('get/{ID}','API\AnswerController@single');
    Route::post('create','API\AnswerController@create');
    Route::post('update','API\AnswerController@update');
    Route::delete('delete','API\AnswerController@delete');
});

Route::prefix('virtual_classroom')->group(function(){
    Route::get('{teacher_id}','API\VirtualClassroomController@index');
    Route::get('get/{ID}','API\VirtualClassroomController@single');
    Route::post('create','API\VirtualClassroomController@create');
    Route::post('update','API\VirtualClassroomController@update');
    Route::delete('delete','API\VirtualClassroomController@delete');
});
