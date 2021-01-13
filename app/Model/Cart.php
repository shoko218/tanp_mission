<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded=['id','count'=>1,'created_at','updated_at'];

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }
}
