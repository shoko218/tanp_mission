<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function __invoke()
    {
        return view('mypage.order_history');
    }
}
