<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Catalog;

class RemoveProcessController extends Controller
{
    public function __invoke(Request $request){//カタログから商品を取り除く
        try {
            $catalog=Catalog::find($request->catalog_id);
            // if($catalog->did_send_mail){
            //     return redirect('mypage/original_catalog')->with('err_msg','既に相手に送っているカタログは編集できません。');
            // }
            // DB::table('catalog_product')
            // ->select('*')
            // ->where('catalog_id','=',$request->catalog_id)
            // ->where('product_id','=',$request->product_id)
            // ->delete();
        } catch (\Throwable $th) {
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('mypage/original_catalog/'.$request->catalog_id)->with('suc_msg','削除しました。');
    }
}
