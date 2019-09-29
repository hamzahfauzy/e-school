@extends('layouts.admin')
@section('title','Exam')
@section('content')
	<div id="app">
		<exam-component role_id="{{$role_id}}"></exam-component>
	</div>            
@endsection