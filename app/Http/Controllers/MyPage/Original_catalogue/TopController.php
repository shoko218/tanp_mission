<?php

namespace App\Http\Controllers\MyPage\Original_catalogue;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function __invoke()
    {
        return view('mypage.original_catalogue.top');
    }
}
