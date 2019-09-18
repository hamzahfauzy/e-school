<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function logoutApi()
    { 
        if (Auth::check()) {
           Auth::user()->AauthAcessToken()->delete();
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details(Request $request) 
    { 
        if (Auth::check()) {
            $user = Auth::user();
            $user->roles;
            foreach($user->roles as $role){
                $role->application_portal;
            }
            return response()->json($user, $this->successStatus); 
        }
    }

    public function role() 
    { 
        $user = Auth::user();
        $user->roles;
        foreach($user->roles as $role){
            $role->application_portal;
        }
        return response()->json($user, $this->successStatus); 
    }

    public function test()
    {
        return 1;
    }

    public function index(){
        $users = User::get();
        foreach($users as $user){
            $user->roles;
        }
        return response()->json($users, $this->successStatus);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::find($request->id);
        $user->update($input);
        return response()->json(['success'=>1], $this->successStatus);
    }

    public function single($id){
        $user = User::find($id);
        $user->roles;
        return response()->json($user,$this->successStatus);
    }

    public function delete(Request $request){ 
        $user = User::find($request->id);
        if(empty($user)){
            return response()->json(['error'=>1],401);
        }
        $user->delete();
        return response()->json(['success'=>1],$this->successStatus);
    }

    public function addRole(Request $request){
        $user = User::find($request->user_id);
        $user->roles()->attach($request->role_id);
        return response()->json(['success'=>1],$this->successStatus);
    }

    public function deleteRole(Request $request){
        $user = User::find($request->user_id);
        $user->roles()->detach($request->role_id);
        return response()->json(['success'=>1],$this->successStatus);
    }
}
