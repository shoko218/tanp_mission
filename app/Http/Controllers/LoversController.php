<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoversController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers');
    }
}
