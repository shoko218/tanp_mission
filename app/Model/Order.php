<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $rules=array(
        'forwarding_last_name'=>['required', 'string', 'max:32'],
        'forwarding_first_name'=>['required', 'string', 'max:32'],
        'forwarding_last_name_furigana'=>['required', 'string', 'max:64'],
        'forwarding_first_name_furigana'=>['required', 'string', 'max:64'],
        'forwarding_postal_code'=>['required','string','digits:7'],
        'forwarding_prefecture_id'=>['required','integer'],
        'forwarding_address'=>['required','string', 'max:200'],
        'forwarding_telephone'=>['required','string', 'max:21'],
        'gender'=>['nullable','integer'],
        'relationship_id'=>['nullable','integer'],
        'age'=>['nullable','integer','max:150'],
        'scene_id'=>['nullable','integer'],
        'user_id'=>['nullable','integer'],
        'lover_id'=>['nullable','integer'],
        'user_last_name'=>['required', 'string', 'max:32'],
        'user_first_name'=>['required', 'string', 'max:32'],
        'user_last_name_furigana'=>['required', 'string', 'max:64'],
        'user_first_name_furigana'=>['required', 'string', 'max:64'],
        'user_postal_code'=>['required','string','digits:7'],
        'user_prefecture_id'=>['required','integer'],
        'user_address'=>['required','string', 'max:200'],
        'user_telephone'=>['required','string', 'max:21'],
    );

    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }

    public function order_logs(){
        return $this->hasMany('App\Model\Order_log');
    }
}
