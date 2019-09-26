<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Announcement;
use Validator;

class AnnouncementController extends Controller
{
    public $success = 200;

    public function index(){
        $announcements = Announcement::get();
        return response()->json($announcements,$this->success);
    }

    public function single($id){
        $announcement = Announcement::find($id);
        return response()->json($announcement,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'  =>  'required',
            'teacher_id'    =>  'required',
            'messages'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('classroom_id','teacher_id','messages');
        $announcement = Announcement::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'      =>  'required',
            'teacher_id'      =>  'required',
            'messages'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('classroom_id','teacher_id','messages');
        $announcement = Announcement::find($request->id);
        $announcement->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $announcement = Announcement::find($request->id);
        $announcement->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
