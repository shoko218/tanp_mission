<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductFavoriteController extends Controller
{
    public function __invoke(Request $request){//いいね/いいね解除処理
        $user_id=Auth::user()->id;
        $favorited=Favorite::where('product_id',$request->product_id)->where('user_id',$user_id)->first();//既にいいねをしているか調べる
        if($favorited==null){//していなければレコードを作る
            $fav=new Favorite();
            $fav->user_id=$user_id;
            $fav->product_id=$request->product_id;
            $fav->save();
            $is_fav=true;
        }else{//していれば削除する
            $favorited->delete();
            $is_fav=false;
        }
        $params=['is_fav'=>$is_fav];
        return $params;
    }
}
