<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Catalog;
use App\Model\CatalogProduct;

class RemoveProcessController extends Controller
{
    public function __invoke(Request $request){//カタログから商品を取り除く
        try {
            $catalog=Catalog::find($request->catalog_id);
            if($catalog->did_send_mail){//既に相手に送っているカタログならエラー
                return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','既に相手に送信しているカタログは編集できません。');
            }

            $catalog_product = CatalogProduct::where('catalog_id','=',$request->catalog_id)
            ->where('product_id','=',$request->product_id)
            ->first();

            if($catalog_product != null){
                $catalog_product->delete();
                return redirect('mypage/original_catalog/'.$request->catalog_id)->with('suc_msg','削除しました。');
            }else{//カタログに登録されていない商品が指定されていたらエラー
                return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','エラーが発生しました。');
            }
        } catch (\Throwable $th) {
            return back()->with('err_msg','エラーが発生しました。');
        }
    }
}
