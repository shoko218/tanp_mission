<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order_log extends Model
{
    protected $fillable = ['order_id','product_id','count_id'];

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }

    public function order(){
        return $this->belongsTo('App\Model\Order');
    }

    public function event(){
        return $this->belongsTo('App\Model\Event');
    }
}
