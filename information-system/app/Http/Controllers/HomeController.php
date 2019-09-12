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

    public function employees(){
        return view('employee.index');
    }

    public function majors(){
        return view('major.index');
    }

    public function studies(){
        return view('study.index');
    }

    public function schedules(){
        return view('schedule.index');
    }
}
