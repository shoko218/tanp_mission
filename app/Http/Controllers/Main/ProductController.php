<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Model\Cart;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $product=Product::where('id',$request->input('id'))->first();
        if(Auth::check()){
            $user_id=Auth::user()->id;
            if(Favorite::where('product_id',$request->input('id'))->where('user_id',Auth::user()->id)->first()){
                $is_fav=true;
            }else{
                $is_fav=false;
            }
            if(Cart::select('id')->where('user_id','=',$user_id)->where('product_id','=',$request->input('id'))->first()){
                $is_in_cart=true;
            }else{
                $is_in_cart=false;
            }
        }else{
            $is_fav=false;
            $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
            if(in_array($request->input('id'),$product_ids)!=null){
                $is_in_cart=true;
            }else{
                $is_in_cart=false;
            }
        }
        $param=['product'=>$product,'is_fav'=>$is_fav,'is_in_cart'=>$is_in_cart];
        return view('main.product',$param);
    }
}
