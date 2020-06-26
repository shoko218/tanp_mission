<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoverController extends Controller
{
    public function __invoke(Request $request)
    {
        $param=['id'=>$request->id,'name'=>$request->name];
        return view('mypage.lovers.lover',$param);
    }
}
