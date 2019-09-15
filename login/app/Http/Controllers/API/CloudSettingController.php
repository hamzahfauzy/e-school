<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CloudSetting;

class CloudSettingController extends Controller
{
    //

    function index()
    {
    	$model = CloudSetting::find(1);
    	if(!empty($model))
    		return response()->json($model,200);
    	else
    		return response()->json([],200);
    }

    function update(Request $request)
    {
    	$model = CloudSetting::find(1);
    	if(empty($model))
    		$model = new CloudSetting;

    	$model->max_disk_quota = $request->quota;
    	$model->save();

    	return 1;
    }
}
