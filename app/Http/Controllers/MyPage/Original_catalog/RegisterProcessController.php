<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)//新しくカタログを作成する
    {
        $this->validate($request, Catalog::$rules);
        try {
            $catalog=new Catalog();
            $catalog->user_id=Auth::user()->id;
            $catalog->url_str=strtolower(substr(str_replace(['/', '+'], ['_'], base64_encode(random_bytes(32))), 0, 32));//メール送信時に添付するURLにつけるランダムな文字列
            $catalog->fill($request->all())->save();
        } catch (\Throwable $th) {
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('/mypage/original_catalog')->with('suc_msg','カタログを作成しました。');
    }
}
