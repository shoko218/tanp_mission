<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lover extends Model
{
    public function order(){
        return $this->belongsTo('App\Model\Order');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
