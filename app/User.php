<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailCustom;
use App\Notifications\PasswordResetNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','first_name','last_name_furigana','first_name_furigana','email', 'password','birthday','gender','postal_code','prefecture_id','address','telephone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = ['birthday'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static $except_mail_pass_rules=array(
        'last_name'=>['required', 'string', 'max:32'],
        'first_name'=>['required', 'string', 'max:32'],
        'last_name_furigana'=>['required', 'string', 'max:64','katakana'],
        'first_name_furigana'=>['required', 'string', 'max:64','katakana'],
        'birthday'=>['required','date'],
        'gender'=>['required','integer'],
        'postal_code'=>['nullable','string','digits:7','hankakunum'],
        'prefecture_id'=>['nullable','integer'],
        'address'=>['nullable','string', 'max:200','text'],
        'telephone'=>['nullable','string','min:9','max:27','hankakunum'],
    );

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailCustom);
    }

    /**
     * Override to send for password reset notification.
     *
     * @param [type] $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function catalogs(){
        return $this->hasMany('App\Model\Catalog');
    }

    public function prefecture(){
        return $this->belongsTo('App\Model\Prefecture');
    }
}
