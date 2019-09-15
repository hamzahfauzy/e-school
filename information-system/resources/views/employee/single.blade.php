@extends('layouts.admin')
@section('title','Pegawai')
@section('content')
    <div id="app">
        <employee-single-component :employee="{{$employee}}"></employee-single-component>
    </div>
@endsection