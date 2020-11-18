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
        $catalog=Catalog::select('*')->where('url_str','=',$url_str)->first();
        if($catalog==null||$request->product_id==null){
            return redirect('/msg')->with('title','エラー')->with('msg','エラーが発生しました。');
        }
        if ($catalog->selected_id==null) {//まだカタログの商品を選んでいないか確認
            $catalog_products=DB::table('catalog_product')
            ->select('product_id')
            ->where('catalog_id', '=', $catalog->id)
            ->get();
            $catalog_product_ids=[];
            foreach ($catalog_products as $catalog_product) {
                $catalog_product_ids[]=(string)$catalog_product->product_id;
            }
            if (!in_array($request->product_id, $catalog_product_ids, true)) {//カタログの中にある商品か確認
                return redirect('/msg')->with('title','エラー')->with('msg','エラーが発生しました。');
            }
            $product=Product::where('id', $request->input('id'))->first();
            $param=['product'=>$product,'url_str'=>$url_str];
            return view('main.select_product_detail', $param);
        }else{
            return redirect('/msg')->with('title','エラー')->with('msg','既に商品を選択されています。');
        }
    }
}
