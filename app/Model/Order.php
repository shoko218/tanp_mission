<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded=['id','created_at','updated_at'];

    public static $rules=array(
        'forwarding_last_name' => ['required', 'string', 'max:32'],
        'forwarding_first_name' => ['required', 'string', 'max:32'],
        'forwarding_last_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'forwarding_first_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'forwarding_postal_code' => ['required','string','digits:7','hankakunum'],
        'forwarding_prefecture_id' => ['required','integer'],
        'forwarding_address' => ['required','string', 'max:200','text'],
        'forwarding_telephone' => ['nullable','string','min:9','max:27','hankakunum'],
        'gender' => ['nullable','integer'],
        'relationship_id' => ['nullable','integer'],
        'age' => ['nullable','integer','min:0','max:150'],
        'scene_id' => ['nullable','integer'],
        'lover_id' => ['nullable','integer'],
        'user_last_name' => ['required', 'string', 'max:32'],
        'user_first_name' => ['required', 'string', 'max:32'],
        'user_last_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'user_first_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'user_postal_code' => ['required','string','digits:7','hankakunum'],
        'user_prefecture_id' => ['required','integer'],
        'user_address' => ['required','string', 'max:200','text'],
        'user_email' => ['required', 'email', 'max:255'],
        'user_telephone' => ['nullable','string','min:9','max:27','hankakunum'],
    );

    public function order_logs()
    {
        return $this->hasMany('App\Model\Order_log');
    }
}
