<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationPortal extends Model
{
    protected $guarded = [];
    
    public $timestamps = false;

    public function roles(){
        return $this->hasMany(Role::class);
    }
}
