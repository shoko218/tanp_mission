<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prefecture;
use App\Model\Relationship;

class RegisterController extends Controller
{
    public function __invoke()//大切な人登録画面表示
    {
        $prefectures = Prefecture::select('id','name')->get();
        $relationships = Relationship::select('id','name')->get();
        $param=['prefectures'=>$prefectures,'relationships'=>$relationships];
        return view('mypage.lovers.register',$param);
    }
}
