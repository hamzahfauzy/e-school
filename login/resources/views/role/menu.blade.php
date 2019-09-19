@extends('layouts.admin')
@section('title','Roles Management')
@section('content')
    <div id="app">
        <menu-component role_id='{{$role_id}}'></menu-component>
    </div>
@endsection