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
        if (Auth::check()) {//会員ならDBでの処理
            try {
                $user_id = Auth::user()->id;
                $target = Cart::where('user_id', '=', $user_id)->where('product_id', '=', $request->product_id)->first();//既にカートの中に同じ商品が入っているか確認
                if ($target != null) {//入っていれば(=2個目以降)該当レコードの個数フィールドの値を+1
                    $target->update(['count' => $target->count+1]);
                } else {//入っていなければ(=1個目)DBに新規レコードを作成
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->product_id = $request->product_id;
                    $cart->save();
                }
            } catch (\Throwable $th) {
                return back()->with('err_msg', 'エラーが発生しました。時間を開けて再度お試しください。');
            }
        } else {//非会員ならCookieでの処理
            try {
                $product_ids = Cookie::get('cart_product_ids');//Cookieの値(文字列)を取得
                $product_ids .= $request->product_id.',';//取得した文字列の末尾に商品idを追加
                Cookie::queue('cart_product_ids', $product_ids, 86400);//新しい文字列をCookieに登録
            } catch (\Throwable $th) {
                return back()->with('err_msg', 'エラーが発生しました。時間を開けて再度お試しください。');
            }
        }
        return redirect('/cart')->with('suc_msg', 'カートに追加しました。');
    }
}
