<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //
    protected $guarded = [];

    function items(){
    	return $this->hasMany(ExamItem::class,'exam_id','id');
    }
}
