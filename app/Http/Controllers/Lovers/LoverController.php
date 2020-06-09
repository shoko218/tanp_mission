<?php

namespace App\Http\Controllers\lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoverController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.lover');
    }
}
