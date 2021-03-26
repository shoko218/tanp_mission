<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogMail;
use App\Model\CatalogProduct;
use Illuminate\Support\Facades\DB;

class SendProcessController extends Controller
{
    public function __invoke(Request $request)//カタログメールを相手に送る

    {
        $catalog = Catalog::find($request->catalog_id);
        if ($catalog->did_send_mail == false) {//まだメールを送っていなければ
            if (CatalogProduct::where('catalog_id', $catalog->id)->count() > 1) {//カタログに登録した商品数が2つ以上なら
                DB::beginTransaction();
                try {
                    Catalog::where('id', $catalog->id)->update(['did_send_mail' => true]);
                    Mail::to($catalog->email)->send(new CatalogMail($catalog));
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg', 'エラーが発生しました。');
                }
                return redirect('mypage/original_catalog/'.$catalog->id)->with('suc_msg', '送信しました。');
            } else {
                return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg', 'カタログを送信できるのは商品を二つ以上登録してからです。');
            }
        } else {//既にメールを送っていれば
            return redirect('mypage/original_catalog/'.$catalog->id)->with('err_msg', '既にカタログを送信しています。');
        }
    }
}
