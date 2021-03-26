<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prefecture;

class EditController extends Controller
{
    public function __invoke()
    {
        $prefectures = Prefecture::select('id', 'name')->get();
        $param = ['prefectures' => $prefectures];
        return view('mypage.register_info.edit', $param);
    }
}
