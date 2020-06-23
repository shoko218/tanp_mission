<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Model\Prefecture;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        $prefectures = Prefecture::select('id','name')->get();
        $param=['prefectures'=>$prefectures];
        return view('auth.register', $param);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'last_name'=>['required', 'string', 'max:32'],
            'first_name'=>['required', 'string', 'max:32'],
            'last_name_furigana'=>['required', 'string', 'max:64'],
            'first_name_furigana'=>['required', 'string', 'max:64'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthday'=>['required','date'],
            'gender'=>['required','integer'],
            'postal_code'=>['nullable','string','digits:7'],
            'prefecture_id'=>['nullable','integer'],
            'address'=>['nullable','string', 'max:200'],
            'telephone'=>['nullable','string', 'max:21'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'last_name'=>$data['last_name'],
            'first_name'=>$data['first_name'],
            'last_name_furigana'=>$data['last_name_furigana'],
            'first_name_furigana'=>$data['first_name_furigana'],
            'email' =>$data['email'],
            'password' => Hash::make($data['password']),
            'birthday'=>$data['birthday'],
            'gender'=>$data['gender'],
            'postal_code'=>$data['postal_code'],
            'prefecture_id'=>$data['prefecture_id'],
            'address'=>$data['address'],
            'telephone'=>$data['telephone'],
        ]);
    }
}
