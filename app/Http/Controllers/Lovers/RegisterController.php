<?php

namespace App\Http\Controllers\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.lover_register');
    }
}
