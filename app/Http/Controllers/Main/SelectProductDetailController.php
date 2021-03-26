<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Catalog;
use Illuminate\Support\Facades\DB;

class SelectProductDetailController extends Controller
{
    public function __invoke(Request $request,$url_str)//カタログ受取人用の商品詳細画面を表示
    {
        $catalog = Catalog::select('*')->where('url_str','=',$url_str)->first();
        if($catalog != null){//カタログの存在確認
            if($catalog->did_send_mail == true){//カタログの送信確認
                if ($catalog->selected_id == null) {//まだカタログの商品を選んでいないか確認
                    $catalog_products=DB::table('catalog_product')
                    ->select('product_id')
                    ->where('catalog_id',$catalog->id)
                    ->get();
                    $catalog_product_ids = [];
                    foreach ($catalog_products as $catalog_product) {
                        $catalog_product_ids[] = (string)$catalog_product->product_id;
                    }
                    if (in_array($request->input('id'), $catalog_product_ids, true)) {//カタログの中にある商品か確認
                        $product = Product::where('id', $request->input('id'))->first();
                        $param = ['product' => $product,'url_str' => $url_str];
                        return view('main.select_product_detail', $param);
                    }else{//カタログの中にない商品ならエラー
                        return redirect('/select_product/'.$url_str)->with('err_msg','エラーが発生しました。');
                    }
                }else{
                    return redirect('/msg')->with('title','選択済み')->with('msg','既に商品が選択されています。');
                }
            }else{//まだ送信されていないカタログならエラー
                return redirect('/')->with('err_msg','無効なURLです。');
            }
        }else{//カタログが存在していなければエラー
            return redirect('/')->with('err_msg','無効なURLです。');
        }
    }
}
