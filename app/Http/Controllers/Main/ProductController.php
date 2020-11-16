<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $product=Product::where('id',$request->input('id'))->first();//商品詳細ページ表示
        if(Auth::check()){
            $user_id=Auth::user()->id;
            if(Favorite::where('product_id',$request->input('id'))->where('user_id',$user_id)->first()){//いいねをしているか
                $is_fav=true;
            }else{
                $is_fav=false;
            }
        }else{
            $is_fav=false;
        }
        $param=['product'=>$product,'is_fav'=>$is_fav];
        return view('main.product_detail',$param);
    }
}
