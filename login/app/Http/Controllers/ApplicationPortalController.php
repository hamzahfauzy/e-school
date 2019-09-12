<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationPortalController extends Controller
{
    public function index(){
        return view('application_portal.index');
    }
}
