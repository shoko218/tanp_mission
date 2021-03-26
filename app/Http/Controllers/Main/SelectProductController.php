<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Catalog;

class SelectProductController extends Controller
{
    public function __invoke($url_str,Request $request){//受取人のカタログ画面を表示
        $catalog=Catalog::select('*')
        ->where('url_str','=',$url_str)
        ->first();

        if($catalog !== null){//カタログの存在確認
            if($catalog->did_send_mail == true){//カタログの送信確認
                if($catalog->selected_id === null){//まだ商品が選ばれていないか確認
                    $param = ['catalog' => $catalog];
                    return view('main.select_product',$param);
                }else{//既に商品を選んだカタログの場合は既に商品が選択されている旨を表示
                    return redirect('/msg')->with('title','選択済み')->with('msg','既に商品が選択されています。');
                }
            }else{//まだ送信されていないカタログならエラー
                return redirect('/')->with('err_msg','無効なURLです。');
            }
        }else{//カタログがなければエラー
            return redirect('/')->with('err_msg','無効なURLです。');
        }

    }
}
