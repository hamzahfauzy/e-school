<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('index');
    }

    public function class_rooms(){
        return view('class_room.index');
    }

    public function students(){
        return view('student.index');
    }
}
