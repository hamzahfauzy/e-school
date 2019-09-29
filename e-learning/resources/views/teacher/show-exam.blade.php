@extends('layouts.admin')
@section('title','Exam - Detail')
@section('content')
	<div id="app">
		<show-exam-component role_id="{{$role_id}}" exam_id="{{$exam->id}}" study_id="{{$exam->study_id}}"></show-exam-component>
	</div>            
@endsection