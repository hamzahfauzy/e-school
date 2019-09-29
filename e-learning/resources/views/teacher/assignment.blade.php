@extends('layouts.admin')
@section('title','Assignment')
@section('content')
	<div id="app">
		<assignment-component role_id="{{$role_id}}"></assignment-component>
	</div>            
@endsection