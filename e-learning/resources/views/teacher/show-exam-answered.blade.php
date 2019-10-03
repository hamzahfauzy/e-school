@extends('layouts.admin')
@section('title','Exam Answered')
@section('content')
	<div id="app">
		<show-exam-answered-component role_id="{{$role_id}}" exam_id="{{$exam->id}}" study_id="{{$exam->study_id}}" />
	</div>            
@endsection