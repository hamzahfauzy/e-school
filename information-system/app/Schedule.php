<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function study_teacher(){
        return $this->belongsTo(Employee::class,'study_teacher_id');
    }
}
