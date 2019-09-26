<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function announcement(){
        return view("announcement.index",['role_id' => session('role_id')]);
    }
}
