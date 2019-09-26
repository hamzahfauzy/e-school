@extends('layouts.admin')
@section('title','Announcements')
@section('content')
	<div id="app">
		<announcement-component role_id="{{$role_id}}"></announcement-component>
	</div>            
@endsection