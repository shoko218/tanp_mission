<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogReplyNotificationMail;
use Exception;
use Illuminate\Support\Facades\DB;

class SelectProductProcessController extends Controller
{
    public function __invoke(Request $request,$url_str){//カタログへの回答を登録
        $catalog=Catalog::select('*')->where('url_str','=',$url_str)->first();
        if($catalog==null||$request->product_id==null){
            return redirect('/msg')->with('title','エラー')->with('msg','エラーが発生しました。');
        }
        if($catalog->selected_id==null){
            try {
                $catalog_products=DB::table('catalog_product')
                ->select('product_id')
                ->where('catalog_id','=',$catalog->id)
                ->get();
                $catalog_product_ids=[];
                foreach($catalog_products as $catalog_product){
                    $catalog_product_ids[]=(string)$catalog_product->product_id;
                }
                if(in_array($request->product_id,$catalog_product_ids,true)){//選ばれた商品がカタログに入れられているものであるか確認
                    Catalog::where('url_str','=',$url_str)->update(['selected_id'=>$request->product_id]);
                    Mail::to($catalog->user->email)->send(new CatalogReplyNotificationMail($catalog));//送り主に回答が届いた旨のメールを送信
                }else{
                    throw new Exception();
                }
            } catch (\Throwable $th) {
                return redirect('/select_product/'.$catalog->url_str)->with('err_msg','エラーが発生しました。');
            }
            return redirect('/msg')->with('title','送信完了')->with('msg','送信しました。');
        }else{
            return redirect('/msg')->with('title','選択済み')->with('msg','既に選択されています。');
        }
    }
}
