<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Schedule;

class ScheduleController extends Controller
{
    public $success = 200;

    public function index(){
        $studies = Schedule::get();
        return response()->json($studies,$this->success);
    }

    public function single($id){
        $study = Schedule::find($id);
        return response()->json($study,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'study_teacher_id'  =>  'required',
            'day'               =>  'required',
            'time_start'        =>  'required',
            'time_finish'       =>  'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('study_teacher_id','day','time_start','time_finish');
        $study = Schedule::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'study_teacher_id'  =>  'required',
            'day'               =>  'required',
            'time_start'        =>  'required',
            'time_finish'       =>  'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('study_teacher_id','day','time_start','time_finish');
        $study = Schedule::find($request->id);
        $study->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $study = Schedule::find($request->id);
        $study->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
