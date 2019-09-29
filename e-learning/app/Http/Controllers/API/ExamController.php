<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Exam;

class ExamController extends Controller
{
    //
    public $success = 200;

    public function index($teacher_id){
        $exams = Exam::where('teacher_id',$teacher_id)->get();
        return response()->json($exams,$this->success);
    }

    public function single($id){
        $exam = Exam::find($id);
        return response()->json($exam,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'name'      	=>  'required',
            'exam_type'		=>  'required',
            'classroom_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('teacher_id','study_id','name','exam_type','classroom_id');
        $exam = Exam::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'id'            =>  'required',
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'name'      	=>  'required',
            'exam_type' 	=>  'required',
            'classroom_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('teacher_id','id','study_id','name','exam_type','classroom_id');
        $exam = Exam::find($request->id);
        if($exam->teacher_id == $request->teacher_id)
        {
	        $exam->update($input);
	        return response()->json(['success'=>1],$this->success);
	    }
	    return response()->json(['success'=>0],$this->success);
    }

    public function delete(Request $request){
        $exam = Exam::find($request->id);
        if($exam->teacher_id == $request->teacher_id)
        {
	        $exam->delete();
	        return response()->json(['success'=>1],$this->success);
        }
	    return response()->json(['success'=>0],$this->success);
    }
}
