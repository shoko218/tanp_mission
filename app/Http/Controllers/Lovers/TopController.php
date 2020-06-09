<?php

namespace App\Http\Controllers\Lovers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.top');
    }
}
