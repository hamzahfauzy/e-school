@extends('layouts.admin')
@section('title','Exam Panel')
@section('content')
	<div id="app">
		<panel-exam-component role_id="{{$role_id}}" exam_id="{{$exam->id}}" study_id="{{$exam->study_id}}" />
	</div>            
@endsection