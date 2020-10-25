<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Catalog;

class SelectProductController extends Controller
{
    public function __invoke($catalog_param,Request $request){
        $catalog=Catalog::select('*')
        ->where('url_str','=',$catalog_param)
        ->first();
        if($catalog->selected_id!=null){
            return redirect('/msg')->with('title','選択済み')->with('msg','既に商品が選択されています。');
        }else if($catalog!=null&&$catalog->did_send_mail){
            $param=['catalog'=>$catalog];
            return view('main.select_product',$param);
        }else{
            return redirect('/')->with('err_msg','無効なURLです。');
        }
    }
}
