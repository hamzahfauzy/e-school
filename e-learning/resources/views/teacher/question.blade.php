@extends('layouts.admin')
@section('title','Question')
@section('content')
	<div id="app">
		<question-component role_id="{{$role_id}}"></question-component>
	</div>            
@endsection