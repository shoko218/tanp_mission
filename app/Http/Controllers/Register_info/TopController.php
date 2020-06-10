<?php

namespace App\Http\Controllers\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function __invoke()
    {
        return view('mypage.register_info.top');
    }
}
