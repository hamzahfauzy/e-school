<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function application_portal(){
        return $this->belongsTo(ApplicationPortal::class,'app_id');
    }

    public function menus()
    {
    	return $this->hasMany(Menu::class,'role_id','id');
    }
}
