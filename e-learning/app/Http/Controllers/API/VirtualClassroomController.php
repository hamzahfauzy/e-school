<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VirtualClassroom;
use Validator;

class VirtualClassroomController extends Controller
{
    //
    public $success = 200;

    public function index($teacher_id){
        $virtualClassrooms = VirtualClassroom::where('teacher_id',$teacher_id)->get();
        return response()->json($virtualClassrooms,$this->success);
    }

    public function single($id){
        $virtualClassroom = VirtualClassroom::find($id);
        return response()->json($virtualClassroom,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'title'      	=>  'required',
            'description'   =>  'required',
            'classroom_id'  =>  'required',
            'file_url'  	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('teacher_id','study_id','title','description','classroom_id','file_url');
        $input['status'] = 0;
        $virtualClassroom = VirtualClassroom::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'id'            =>  'required',
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'title'      	=>  'required',
            'description'   =>  'required',
            'classroom_id'  =>  'required',
            'file_url'  	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('teacher_id','id','study_id','title','description','classroom_id','file_url');
        $input['status'] = 0;
        $virtualClassroom = VirtualClassroom::find($request->id);
        $virtualClassroom->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $virtualClassroom = VirtualClassroom::find($request->id);
        if($virtualClassroom->teacher_id == $request->teacher_id)
        {
	        $virtualClassroom->delete();
	        return response()->json(['success'=>1],$this->success);
        }
	    return response()->json(['success'=>0],$this->success);
    }
}
