<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class MainController extends Controller
{
    //

    function index()
    {
        return view('admin');
    }

    function login()
    {
        return view('login');
    }

    public function dashboard(){
        $data['users'] = User::get();
        $data['roles'] = Role::get();
        return view('dashboard',$data);
    }
}
