@extends('layouts.admin')
@section('title','Class Room Single')
@section('content')
    <div id="app">
        <class-room-single-component :class_room="{{$class_room}}"></class-room-single-component>
    </div>
@endsection