<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lover extends Model
{
    protected $guarded =array('id');

    public static $rules=array(
        'last_name'=>['required', 'string', 'max:32'],
        'first_name'=>['required', 'string', 'max:32'],
        'last_name_furigana'=>['required', 'string', 'max:64'],
        'first_name_furigana'=>['required', 'string', 'max:64'],
        'birthday'=>['required','date'],
        'gender'=>['required','integer'],
        'relationship_id'=>['required','integer'],
        'user_id'=>['required','integer'],
        'postal_code'=>['nullable','string','digits:7'],
        'prefecture_id'=>['nullable','integer'],
        'address'=>['nullable','string', 'max:200'],
        'telephone'=>['nullable','string', 'max:21'],
        'file'=>['nullable','file','mimes:jpeg,png,jpg','max:2048'],
    );

    public function order(){
        return $this->belongsTo('App\Model\Order');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
