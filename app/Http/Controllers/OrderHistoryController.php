<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function __invoke()
    {
        return view('mypage.order_history');
    }
}
