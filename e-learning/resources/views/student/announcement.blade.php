@extends('layouts.admin')
@section('title','Announcements')
@section('content')
	<div id="app">
		<student-announcement-component role_id="{{$role_id}}"></student-announcement-component>
	</div>            
@endsection