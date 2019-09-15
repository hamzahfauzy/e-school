<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classroom;
use Validator;

class ClassRoomController extends Controller
{
    public $success = 200;


    public function index(){
        $class_rooms = Classroom::get();
        foreach($class_rooms as $class_room){
            $class_room->major;
            $class_room->employee;
        }
        return response()->json($class_rooms,$this->success);
    }

    public function single($id){
        $class_room = Classroom::find($id);
        $class_room->major;
        $class_room->employee;
        return response()->json($class_room,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'          =>  'required',
            'major_id'      =>  'required',
            'employee_id'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('name','major_id','employee_id');
        $class_room = Classroom::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'name'          =>  'required',
            'major_id'      =>  'required',
            'employee_id'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('name','major_id','employee_id');
        $class_room = Classroom::find($request->id);
        $class_room->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $class_room = Classroom::find($request->id);
        $class_room->delete();
        return response()->json(['success'=>1],$this->success);
    }
}