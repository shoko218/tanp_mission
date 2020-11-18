<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Catalog;

class SelectProductController extends Controller
{
    public function __invoke($catalog_param,Request $request){//受取人のカタログ画面を表示
        $catalog=Catalog::select('*')
        ->where('url_str','=',$catalog_param)
        ->first();
        if($catalog->selected_id!=null){//既に商品を選んだカタログの場合は既に商品が選択されている旨を表示
            return redirect('/msg')->with('title','選択済み')->with('msg','既に商品が選択されています。');
        }else if($catalog!=null&&$catalog->did_send_mail){//カタログが存在していて受取人あてに送信しているものなら表示
            $param=['catalog'=>$catalog];
            return view('main.select_product',$param);
        }else{//何か問題があればエラー
            return redirect('/')->with('err_msg','無効なURLです。');
        }
    }
}
