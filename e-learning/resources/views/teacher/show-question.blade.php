@extends('layouts.admin')
@section('title','Question - Answer')
@section('content')
	<div id="app">
		<show-question-component role_id="{{$role_id}}" question_id="{{$question->id}}" key_answer_id="{{$question->key_answer_id}}"></show-question-component>
	</div>            
@endsection