@extends('layouts.admin')
@section('title','Exam')
@section('content')
	<div id="app">
		<student-exam-component role_id="{{$role_id}}" />
	</div>            
@endsection