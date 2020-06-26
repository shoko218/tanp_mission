<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    public function events(){
        return $this->hasMany('App\Model\Event');
    }
}
