<?php

namespace App\Http\Controllers\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnniversaryRegisterController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.anniversary_register');
    }
}
