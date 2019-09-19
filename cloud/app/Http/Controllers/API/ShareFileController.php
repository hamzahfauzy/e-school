<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{File,FileShare};

class ShareFileController extends Controller
{
    function index(Request $request){
        $files = FileShare::where('user_id',$request->user_id)->get();
        foreach($files as $file){
            $file->file;
        }
        return response()->json($files,200);
    }
}
