<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoverController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.lover');
    }
}
