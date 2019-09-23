<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Schedule;
use App\EmployeeStudy;

class ScheduleController extends Controller
{
    public $success = 200;

    public function index(){
        $schedules = Schedule::get();
        foreach($schedules as $schedule){
            $schedule->employee_study->employee;
            $schedule->employee_study->class_room->major;
        }
        return response()->json($schedules,$this->success);
    }

    public function single($id){
        $schedule = Schedule::find($id);
        $schedule->employee_study->employee;
        $schedule->employee_study->class_room->major;
        return response()->json($schedule,$this->success);
    }

    public function create(Request $request){
        $time = explode('-',$request->time);
        $es = EmployeeStudy::where('study_id',$request->study_id)->where('employee_id',$request->employee_id)->where('classroom_id',$request->classroom_id)->first();
        $request['study_teacher_id'] = $es->id;
        $request['time_start'] = $time[0];
        $request['time_finish'] = $time[1];

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
