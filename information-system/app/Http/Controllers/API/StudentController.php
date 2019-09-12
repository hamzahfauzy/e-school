<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use Validator;

class StudentController extends Controller
{
    public $success = 200;

    public function index(){
        $class_rooms = Student::get();
        return response()->json($class_rooms,$this->success);
    }

    public function single($id){
        $class_room = Student::find($id);
        return response()->json($class_room,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'NISN'      =>  'required',
            'name'      =>  'required',
            'address'   =>  'required',
            'gender'    =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('NISN','name','address','gender');
        $class_room = Student::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'NISN'      =>  'required',
            'name'      =>  'required',
            'address'      =>  'required',
            'gender'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('NISN','name','address','gender');
        $class_room = Student::find($request->id);
        $class_room->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $class_room = Student::find($request->id);
        $class_room->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
