@extends('layouts.admin')
@section('title','Virtual Classroom')
@section('content')
	<div id="app">
		<virtual-classroom-component role_id="{{$role_id}}"></virtual-classroom-component>
	</div>            
@endsection