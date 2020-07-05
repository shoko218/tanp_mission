<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $rules=array(
        'last_name'=>['required', 'string', 'max:32'],
        'first_name'=>['required', 'string', 'max:32'],
        'last_name_furigana'=>['required', 'string', 'max:64'],
        'first_name_furigana'=>['required', 'string', 'max:64'],
        'postal_code'=>['required','string','digits:7'],
        'prefecture_id'=>['required','integer'],
        'address'=>['required','string', 'max:200'],
        'telephone'=>['required','string', 'max:21'],
        'gender'=>['nullable','integer'],
        'relationship_id'=>['nullable','integer'],
        'age'=>['nullable','integer','max:150'],
        'scene_id'=>['nullable','integer'],
        'user_id'=>['nullable','integer'],
        'lover_id'=>['nullable','integer'],
    );

    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }
}
