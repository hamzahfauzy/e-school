<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeStudy extends Model
{
    public $table = 'employee_study';
    protected $guarded = [];

    function employee(){
        return $this->belongsTo(Employee::class);
    }

    function class_room(){
        return $this->belongsTo(Classroom::class,'classroom_id');
    }
    
    function study(){
        return $this->belongsTo(Study::class);
    }
}
