<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use Illuminate\Http\Request;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request)//大切な人から削除
    {
        Lover::find($request->lover_id)->delete();
        return redirect('mypage/lovers/')->with('suc_msg', '削除しました。');
    }
}
