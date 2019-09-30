<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\{Question,Exam,VirtualClassroom};

class HomeController extends Controller
{
    function announcement(){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.announcement",['role_id' => session('role_id')]);
    }

    function assignment(){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.assignment",['role_id' => session('role_id')]);

        if(session('role_id') == env('MIX_EL_STUDENT_ROLE_ID'))
            return view("student.assignment",['role_id' => session('role_id')]);
    }

    function question(){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.question",['role_id' => session('role_id')]);
    }

    function showQuestion(Question $question){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.show-question",['role_id' => session('role_id'),'question' => $question]);
    }

    function exam(){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.exam",['role_id' => session('role_id')]);

        if(session('role_id') == env('MIX_EL_STUDENT_ROLE_ID'))
            return view("student.exam",['role_id' => session('role_id')]);
    }

    function showExam(Exam $exam){
    	if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        	return view("teacher.show-exam",['role_id' => session('role_id'),'exam' => $exam]);
    }

    function panelExam(Exam $exam){
        if(session('role_id') == env('MIX_EL_STUDENT_ROLE_ID'))
            return view("student.panel-exam",['role_id' => session('role_id'),'exam' => $exam]);
    }

    function virtualClassroom(){
        if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        {
            $virtualClassroom = VirtualClassroom::where('status',1)->first();
            if(!empty($virtualClassroom))
                return redirect("virtual-classroom/".$virtualClassroom->id);
            return view("teacher.virtual-classroom",['role_id' => session('role_id')]);
        }
    }

    function startVirtualClassroom(VirtualClassroom $virtualClassroom){
        if($virtualClassroom->status != 0)
            return redirect()->back();
        if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        {
            $virtualClassroom->update([
                'status'   => 1,
                'start_at' => Carbon::now()
            ]);
            return redirect("virtual-classroom/".$virtualClassroom->id);
        }
    }

    function finishVirtualClassroom(VirtualClassroom $virtualClassroom){
        if($virtualClassroom->status != 1)
            return redirect()->back();
        if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
        {
            $virtualClassroom->update([
                'status'   => 2,
                'finish_at' => Carbon::now()
            ]);
            return redirect("virtual-classroom");
        }
    }

    function showVirtualClassroom(VirtualClassroom $virtualClassroom){
        if($virtualClassroom->status != 1)
            return redirect()->back();
        if(session('role_id') == env('MIX_EL_TEACHER_ROLE_ID'))
            return view("teacher.show-virtual-classroom",['role_id' => session('role_id'),'virtualClassroom' => $virtualClassroom]);
    }

}
