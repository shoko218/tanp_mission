<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Model\Cart;
use App\Library\BaseClass;

class CartInController extends Controller
{
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            $user_id=Auth::user()->id;
            $target=Cart::where('user_id', '=', $user_id)->where('product_id', '=', $request->product_id)->first();
            if (!empty($target)) {
                $target->update(['count'=>$target->count+1]);
            } else {
                Cart::create(['user_id'=>$user_id,'product_id'=>$request->product_id,'count']);
            }
        } else {
            $product_ids=Cookie::get('cart_product_ids');
            $product_ids.=$request->product_id.',';
            Cookie::queue('cart_product_ids', $product_ids, 86400);
        }
        return redirect('/cart')->with('suc_msg','カートに追加しました。');
    }
}