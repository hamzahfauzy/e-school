<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Role,Menu};
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

    public function menu(Role $ID)
    {
        return response()->json($ID->menus,$this->successStatus);
    }

    public function menuInsert($ID, Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'url' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['role_id'] = $ID;
        $role = Menu::create($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function menuUpdate($ID, Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'url' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->only('name','url','id');
        $input['role_id'] = $ID;
        $menu = Menu::find($request->id);
        $menu->update($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function findMenu($ID, Menu $menu)
    {
        return response()->json($menu, $this->successStatus);
    }

    public function deleteMenu($ID, Request $request)
    {
        $menu = Menu::find($request->id);
        $menu->delete();
        return response()->json(['success'=>1], $this->successStatus);
    }
}
