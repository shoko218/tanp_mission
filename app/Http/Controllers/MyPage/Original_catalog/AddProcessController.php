<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddProcessController extends Controller
{
    public function __invoke(Request $request){
        $catalog=Catalog::find($request->id);
        if($catalog->did_send_mail==true){
            return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg','そのカタログは既に中身を確定しています。');
        }
        $already=DB::table('catalog_product')
        ->select('*')
        ->where('catalog_id','=',$request->id)
        ->where('product_id','=',$request->product_id)
        ->first();
        if($already){
            return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg','その商品は既にこのカタログに追加されています。');
        }else{
            try {
                $catalog=Catalog::find($request->id);
                $catalog->products()->attach($request->product_id);
                return redirect('mypage/original_catalog/'.$catalog->id)->with('suc_msg','追加しました。');
            } catch (\Throwable $th) {
                return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg','エラーが発生しました。');
            }
        }
    }
}
