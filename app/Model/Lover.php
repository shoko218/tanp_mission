<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lover extends Model
{
    protected $guarded = ['id','user_id','created_at','updated_at','img_path'];

    public static $rules=array(
        'last_name' => ['required', 'string', 'max:32'],
        'first_name' => ['required', 'string', 'max:32'],
        'last_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'first_name_furigana' => ['required', 'string', 'max:64','katakana'],
        'birthday' => ['required','datetype','date','past'],
        'gender' => ['required','integer'],
        'relationship_id' => ['required','integer'],
        'postal_code' => ['nullable','string','digits:7','hankakunum'],
        'prefecture_id' => ['nullable','integer'],
        'address' => ['nullable','string', 'max:200','text'],
        'telephone' => ['nullable','string','min:9','max:27','hankakunum'],
        'image' => ['nullable','file','mimes:jpeg,png,jpg','max:10240'],
    );

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function relationship()
    {
        return $this->belongsTo('App\Model\Relationship');
    }
    public function events()
    {
        return $this->hasMany('App\Model\Event');
    }
}
