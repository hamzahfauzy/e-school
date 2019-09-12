<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationPortal;
use Validator;

class ApplicationPortalController extends Controller
{
    public $successStatus = 200;

    public function index(){
        return response()->json(ApplicationPortal::get(),$this->successStatus);
    }

    public function single($id){
        return response()->json(ApplicationPortal::find($id),$this->successStatus);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [ 
            'app_name' => 'required', 
            'app_url' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $role = ApplicationPortal::create($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [ 
            'app_name' => 'required', 
            'app_url' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $role = ApplicationPortal::find($request->id);
        $role->update($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function delete(Request $request){ 
        $role = ApplicationPortal::find($request->id);
        if(empty($role)){
            return response()->json(['error'=>1],401);
        }
        $role->delete();
        return response()->json(['success'=>1],$this->successStatus);
    }
}
