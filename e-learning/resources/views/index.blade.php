@extends('layouts.admin')
@section('title','Home')
@section('content')
	<div id="app">
		<admin-component role_id="{{$role_id}}"></admin-component>
	</div>            
@endsection