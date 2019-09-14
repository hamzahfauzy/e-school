@extends('layouts.admin')
@section('title','Home')
@section('content')
<div id="app">
	<file-component folder='{{$folder}}' parent='{{$parent}}'></file-component>
</div>            
@endsection