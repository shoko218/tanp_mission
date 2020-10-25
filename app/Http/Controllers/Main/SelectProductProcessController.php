<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogReplyNotificationMail;

class SelectProductProcessController extends Controller
{
    public function __invoke(Request $request,$url_str){
        $catalog=Catalog::select('*')->where('url_str','=',$url_str)->first();
        if($catalog->selected_id==null){
            try {
                Catalog::where('url_str','=',$url_str)->update(['selected_id'=>$request->product_id]);
                Mail::to($catalog->user->email)->send(new CatalogReplyNotificationMail($catalog));
            } catch (\Throwable $th) {
                return redirect('/select_product/'.$catalog->url_str)->with('err_msg','エラーが発生しました。');
            }
            return redirect('/msg')->with('title','送信完了')->with('msg','送信しました。');
        }else{
            return redirect('/msg')->with('title','選択済み')->with('msg','既に選択されています。');
        }
    }
}
