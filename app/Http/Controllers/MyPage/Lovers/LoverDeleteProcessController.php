<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use Illuminate\Http\Request;

class LoverDeleteProcessController extends Controller
{
    public function __invoke(Request $request){
        Lover::find($request->lover_id)->delete();
        return redirect('mypage/lovers/top')->with('suc_msg','削除しました。');
    }
}
