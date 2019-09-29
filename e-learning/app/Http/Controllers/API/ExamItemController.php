<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\{Exam,ExamItem};

class ExamItemController extends Controller
{
    //
    public $success = 200;

    public function index($exam_id){
        $exams = ExamItem::where('exam_id',$exam_id)->get();
        foreach ($exams as $exam) {
        	$exam->exam;
        	$exam->question;
        }
        return response()->json($exams,$this->success);
    }

    public function single($id){
        $exam = ExamItem::find($id);
        return response()->json($exam,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'exam_id'		=>  'required',
            'question_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('exam_id','question_id');
        $exam = ExamItem::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $exam = ExamItem::find($request->id);
	    $exam->delete();
	    return response()->json(['success'=>0],$this->success);
    }
}
