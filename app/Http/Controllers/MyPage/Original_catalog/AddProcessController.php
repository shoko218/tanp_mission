<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $catalog = Catalog::find($request->catalog_id);
            if ($catalog->did_send_mail == true) {//既に中身を確定していればエラー
                return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg', 'そのカタログは既に中身を確定しています。');
            }
            $already = DB::table('catalog_product')
            ->select('*')
            ->where('catalog_id', '=', $request->catalog_id)
            ->where('product_id', '=', $request->product_id)
            ->first();
            if ($already != null) {//既に同じ商品がカタログに入っていればエラー
                return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg', 'その商品は既にこのカタログに追加されています。');
            } else {
                $catalog = Catalog::find($request->catalog_id);
                $catalog->products()->attach($request->product_id);
                return redirect('mypage/original_catalog/'.$catalog->id)->with('suc_msg', '追加しました。');
            }
        } catch (\Throwable $th) {
            return back()->with('err_msg', 'エラーが発生しました。');
        }
    }
}
