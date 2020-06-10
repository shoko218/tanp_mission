<?php

namespace App\Http\Controllers\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiftHistoryController extends Controller
{
    public function __invoke()
    {
        return view('mypage.lovers.gift_history');
    }
}
