<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Employee;

class HomeController extends Controller
{
    public function index(){
        return view('index');
    }

    public function class_rooms(){
        return view('class_room.index');
    }

    public function class_room($name){
        $class_room = Classroom::where('name',$name)->first();
        $class_room->major;
        $class_room->employee;
        $class_room->students;
        return view('class_room.single',['class_room'=>$class_room]);
    }

    public function students(){
        return view('student.index');
    }

    public function employees(){
        return view('employee.index');
    }

    public function employee($name){
        $employee = Employee::where('name',$name)->first();
        $employee->studies;
        $employee->class_rooms;
        return view('employee.single',['employee'=>$employee]);
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
