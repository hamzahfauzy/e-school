<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
class FileController extends Controller
{
    //

    function index($folder = false)
    {
    	$folder = !$folder ? 0 : $folder;
    	$model = Folder::find($folder);
		$parent = $model ? $model->parent_id : -1;
    	return view('file.index',[
    		'folder' => $folder,
    		'parent' => $parent
    	]);
	}
	
	function share(){
		return view('file.share');
	}
}
