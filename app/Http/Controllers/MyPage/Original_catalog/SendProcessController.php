<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogMail;

class SendProcessController extends Controller
{
    public function __invoke(Request $request){
        $catalog=Catalog::select('*')->where('id', $request->catalog_id)->first();
        $did_send=$catalog->did_send_mail;;
        if(!$did_send){
            try {
                Mail::to($catalog->email)->send(new CatalogMail($catalog));
                Catalog::where('id', $request->catalog_id)->update(['did_send_mail' => true]);
            } catch (\Throwable $th) {
                return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','エラーが発生しました。');
            }
            return redirect('mypage/original_catalog/'.$request->catalog_id)->with('suc_msg','送信しました。');
        }else{
            return redirect('mypage/original_catalog/'.$request->catalog_id)->with('err_msg','既に送信しています。');
        }
    }
}
