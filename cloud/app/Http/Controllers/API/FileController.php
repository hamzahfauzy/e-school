<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\{Folder,File,FileShare};

class FileController extends Controller
{
    //
    function index(Request $request, $folder)
    {
    	$folder = $folder ? $folder : 0;
    	$folders = Folder::where('user_id',$request->user_id)->where('parent_id',$folder)->get();
    	$files = File::where('user_id',$request->user_id)->where('folder_id',$folder)->get();
    	foreach($files as $file)
    		$file->storage_url = Storage::url($file->url);

    	return response()->json(['folders'=>$folders,'files'=>$files],200);

    }

    function all(Request $request){
        $files = File::where('user_id',$request->user_id)->orderBy('id','desc')->get();
        foreach($files as $file)
    		$file->storage_url = Storage::url($file->url);
        return response()->json($files,200);
    }

    function single($id){
        $file = File::find($id);
    	$file->storage_url = Storage::url($file->url);
        return response()->json($file,200);
    }

    function upload(Request $request)
    {
    	if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $name=$file->getClientOriginalName();
                $url = $file->storeAs('public/files/'.$request->user_id, $name);

    			$model = new File;
                $model->create([
		    		'folder_id' => $request->parent_id,
		    		'name' => $name,
		    		'url' => $url,
		    		'size' => $file->getSize(),
		    		'user_id' => $request->user_id,
		    	]);
            }
        }

    	return 1;
    }

    function share(Request $request){
        $input = $request->only('file_id','user_id');
        $fs = FileShare::create($input);
        return response()->json(1,200);
    }

    function delete(Request $request)
    {
        $file = File::where('id',$request->id)->where('user_id',$request->user_id)->first();
        Storage::delete($file->url);
        $file->delete();
        return 1;
    }
}
