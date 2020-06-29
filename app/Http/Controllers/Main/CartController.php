<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection;

class CartController extends Controller
{
    public function __invoke()
    {
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $products=Product::join('carts','products.id','=','product_id')
            ->select(DB::raw('products.*'))
            ->where('user_id','=',$user_id)
            ->get();
            if($products->isEmpty()){
                $products=null;
            }
        }else{
            if(Cookie::get('cart_product_ids')!=null){
                $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
                $products = new Collection();
                foreach ($product_ids as $product_id) {
                    $product=Product::select(DB::raw('products.*'))
                    ->where('id','=',$product_id)
                    ->first();
                    $products->push($product);
                }
            }else{
                $products=null;
            }
        }
        $param=['products'=>$products];
        return view('main.cart',$param);
    }
}
