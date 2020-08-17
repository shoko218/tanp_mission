<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, Catalog::$rules);
        Catalog::create(['user_id'=>Auth::user()->id,'name'=>$request->name,'email'=>$request->email,'url_str'=>strtolower(substr(str_replace(['/', '+'], ['_'], base64_encode(random_bytes(32))), 0, 32)),'img_num'=>$request->img_num]);
        return redirect('/mypage/original_catalog/top')->with('suc_msg','カタログを作成しました。');
    }
}
