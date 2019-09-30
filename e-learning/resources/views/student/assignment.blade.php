@extends('layouts.admin')
@section('title','Assignment')
@section('content')
	<div id="app">
		<student-assignment-component role_id="{{$role_id}}"></student-assignment-component>
	</div>            
@endsection