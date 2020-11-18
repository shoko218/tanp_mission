<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogMail;
use Illuminate\Support\Facades\DB;

class SendProcessController extends Controller
{
    public function __invoke(Request $request){//カタログメールを相手に送る
        $catalog=Catalog::find($request->catalog_id);
        $did_send=$catalog->did_send_mail;
        if($did_send==false){//まだメールを送っていなければ
            DB::beginTransaction();
            try {
                Catalog::where('id', $request->catalog_id)->update(['did_send_mail' => true]);
                Mail::to($catalog->email)->send(new CatalogMail($catalog));
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','エラーが発生しました。');
            }
            return redirect('mypage/original_catalog/'.$request->catalog_id)->with('suc_msg','送信しました。');
        }else{//既にメールを送っていなければ
            return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','既に送信しています。');
        }
    }
}
