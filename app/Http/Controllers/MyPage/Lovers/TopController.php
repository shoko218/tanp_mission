<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function __invoke()//大切な人一覧表示
    {
        $user_id = Auth::user()->id;
        $lovers = Lover::where('user_id', $user_id)->get();
        $param = ['lovers' => $lovers];
        return view('mypage.lovers.top', $param);
    }
}
