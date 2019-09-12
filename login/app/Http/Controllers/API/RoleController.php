<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Validator;

class RoleController extends Controller
{
    public $successStatus = 200;

    public function index(){
        $roles = Role::get();
        foreach($roles as $role){
            $role->application_portal;
        }
        return response()->json($roles,$this->successStatus);
    }

    public function single($id){
        $role=Role::find($id);
        $role->application_portal;
        return response()->json($role,$this->successStatus);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'description' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $role = Role::create($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'description' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->only('name','description','app_id');
        $role = Role::find($request->id);
        $role->update($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function delete(Request $request){ 
        $role = Role::find($request->id);
        if(empty($role)){
            return response()->json(['error'=>1],401);
        }
        $role->delete();
        return response()->json(['success'=>1],$this->successStatus);
    }
}
