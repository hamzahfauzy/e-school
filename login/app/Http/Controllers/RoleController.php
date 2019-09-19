<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return view('role.index');
    }

    public function menu($role)
    {
    	return view('role.menu',[
    		'role_id' => $role
    	]);
    }
}
