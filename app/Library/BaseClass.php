<?php
namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use App\Model\Order_log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Model\Product;
use Illuminate\Database\Eloquent\Collection;

class BaseClass
{
    public static function getProductsFromDBCart()
    {//DBからカートの中の商品を取り出す
        $user_id = Auth::user()->id;
        $cart_goods = Cart::join('products', 'products.id', '=', 'product_id')
            ->select(DB::raw('carts.*'))
            ->where('user_id', '=', $user_id)
            ->orderBy('id', 'desc')
            ->with('product.genre')
            ->get();
        return $cart_goods;
    }

    public static function getProductsFromCookieCart($str = null)
    {
        //Cookieからカートの中の商品を取り出す 挙動の関係上、Cookieの更新前にカートの中身を取り出してしまうことがあるので引数からも取れるようにしている

        /*
        Cookie内では 'cart_product_ids'というキーに
            ex. '13,23,9,23,6,6'
        というように、商品を入れた順に並べた文字列が登録されている。
        これをphp内に取り込み、配列化して様々な処理を行うことでそれぞれの商品idや個数、入れた順番などの必要な情報を解釈する。
        */

        if ($str == null) {
            $str = Cookie::get('cart_product_ids');
        }

        $product_ids = explode(',', trim($str, ','));//配列化
        $product_notdup_ids = array_values(array_unique($product_ids));//商品の一つ目を入れた順番を調べる
        $products = new Collection();
        foreach ($product_notdup_ids as $product_notdup_id) {//商品情報を取得する
            $product = Product::select(DB::raw('products.*'))
            ->where('id', '=', $product_notdup_id)
            ->with('genre')
            ->first();
            $products->prepend($product);
        }
        $product_count = array();
        foreach ($product_notdup_ids as $product_notdup_id) {//商品の個数を調べる
            $temp_count = 0;
            foreach ($product_ids as $product_id) {
                if ($product_notdup_id ==  $product_id) {
                    $temp_count++;
                }
            }
            array_unshift($product_count, $temp_count);
        }
        return array($products,$product_count);
    }

    public static function calcPriceInTaxFromDBCart()
    {//DBから取り出したカートの中の商品の合計金額を算出する
        $cart_goods = BaseClass::getProductsFromDBCart();
        $sum_price = 0.0;
        foreach ($cart_goods as $cart_good) {
            if ($cart_good->product->genre_id ==  1) {//食品(軽減税率8％)
                $sum_price += $cart_good->product->price * $cart_good->count * 1.08;
            } else {//その他(税率10%)
                $sum_price += $cart_good->product->price * $cart_good->count * 1.1;
            }
        }
        return floor($sum_price);
    }

    public static function calcPriceInTaxFromCookieCart($products = null, $product_count = null)
    {//Cookieから取り出したカートの中の商品の合計金額を算出する 挙動の関係上、Cookieの更新前にカートの中身を取り出してしまうことがあるので引数からも取れるようにしている
        if ($products ==  null&&$product_count ==  null) {
            list($products, $product_count) = BaseClass::getProductsFromCookieCart();
        } elseif (($products != null && $product_count == null)||($products == null&&$product_count != null)) {
            return -1;
        }
        $sum_price = 0.0;
        foreach ($products as $key => $product) {
            if ($product->genre_id ==  1) {//食品(軽減税率8％)
                $sum_price += $product->price*$product_count[$key] * 1.08;
            } else {//その他(税率10%)
                $sum_price += $product->price*$product_count[$key] * 1.1;
            }
        }
        return floor($sum_price);
    }

    public static function searchProducts($keyword, $target_scene_id, $target_genre_id, $target_relationship_id, $target_gender, $target_generation_id, $sort_by, $limit = null)
    {//検索する関数

        $relevanceSQL = '';

        $countSQL = DB::table('order_logs')
        ->join('orders', 'order_id', '=', 'orders.id')
        ->select('product_id', DB::raw('sum(count) as count'))
        ->groupBy('product_id');

        $mainQuery = Product::leftJoinSub($countSQL, 'counts', 'products.id', 'counts.product_id');//商品情報テーブルに販売個数の情報を付与

        if ($keyword != null) {//キーワード検索
            $temps = explode(" ", $keyword);
            $keywords = [];
            foreach ($temps as $key => $temp) {
                $keywords[$key] = array(//ある程度の表記揺れに対応
                    "normal" => $temp,
                    "hiragana" => mb_convert_kana($temp, "c"),
                    "katakana" => mb_convert_kana($temp, "C"),
                    "lower" => strtolower($temp),
                    "upper" => strtoupper($temp),
                );
            }
            $mainQuery->where(function ($keywordSQL) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $keywordSQL->orwhere('name', 'like', '%'.$keyword['normal'].'%');
                    $keywordSQL->orwhere('name', 'like', '%'.$keyword['hiragana'].'%');
                    $keywordSQL->orwhere('name', 'like', '%'.$keyword['katakana'].'%');
                    $keywordSQL->orwhere('name', 'like', '%'.$keyword['lower'].'%');
                    $keywordSQL->orwhere('name', 'like', '%'.$keyword['upper'].'%');
                }
            });
        } else {//選択検索
            if ($target_scene_id != null) {//シーン検索
                $sceneSQL = Order_log::join('orders', 'order_id', '=', 'orders.id')
                ->select('product_id', DB::raw('count(*) as scene_count_raw'))
                ->where('orders.scene_id', '=', $target_scene_id)
                ->groupBy('product_id');//シーン数別の購入数情報を付与
                $mainQuery->joinSub($sceneSQL, 'scene_counts', 'products.id', 'scene_counts.product_id');
                $relevanceSQL = $relevanceSQL.'`scene_count_raw` + ';
            }

            if ($target_genre_id != null) {//ジャンル検索
                $mainQuery->where('products.genre_id', '=', $target_genre_id);//ジャンル絞りの条件を付与
            }

            if ($target_relationship_id != null) {//関係性検索
                $relationshipSQL = Order_log::join('orders', 'order_id', '=', 'orders.id')
                ->select('product_id', DB::raw('count(*) as relationship_count_raw'))
                ->where('orders.relationship_id', '=', $target_relationship_id)
                ->groupBy('product_id');//関係性別の購入数情報を付与
                $mainQuery->joinSub($relationshipSQL, 'relationship_counts', 'products.id', 'relationship_counts.product_id');
                $relevanceSQL = $relevanceSQL.'`relationship_count_raw` + ';
            }

            if ($target_gender != null) {
                if ($target_gender != 2) {
                    $genderSQL = Order_log::join('orders', 'order_id', '=', 'orders.id')
                    ->select('product_id', DB::raw('count(*) as gender_count_raw'))
                    ->where('orders.gender', '=', $target_gender)
                    ->groupBy('product_id');//性別別での購入数情報を付与
                    $mainQuery->joinSub($genderSQL, 'gender_counts', 'products.id', 'gender_counts.product_id');
                    $relevanceSQL = $relevanceSQL.'`gender_count_raw` + ';
                }
            }

            if ($target_generation_id != null) {
                $generationSQL = Order_log::join('orders', 'order_id', '=', 'orders.id')
                ->select('product_id', DB::raw('count(*) as generation_count_raw'))
                ->where('orders.generation_id', '=', $target_generation_id)
                ->groupBy('product_id');//世代別での購入数情報を付与
                $mainQuery->joinSub($generationSQL, 'generation_counts', 'products.id', 'generation_counts.product_id');
                $relevanceSQL = $relevanceSQL.'`generation_count_raw` + ';
            }

            $relevanceSQL = mb_substr($relevanceSQL, 0, -3, "UTF-8");

            switch ($sort_by) {
                case 0://関連順でソートする
                    $mainQuery->select(DB::raw("products.* ,($relevanceSQL) as relevance_count"))
                    ->orderby('relevance_count', 'desc');
                    break;
                    case 1://人気度の高い順ソートとして購入数でソートする
                    $mainQuery->select('products.*', 'counts.count as count')
                    ->orderby('count', 'desc');
                    break;
                case 2://新着順でソートする
                    $mainQuery->select('products.*')
                    ->orderBy('products.id', 'desc');
                    break;
            }
        }

        if ($limit != null) {//最大個数制限がある場合はそれに従う
            $results = $mainQuery->limit($limit)->get();
        } else {//最大個数制限がなければ12個ずつ表示する
            $results = $mainQuery->paginate(12);
        }
        return $results;
    }

    public static function get_simpson($target, $comparator)
    {//Simpson係数を算出する関数
        $intersec = array_intersect(array_values(array_unique($target)), array_values(array_unique($comparator)));//集合を取る
        $num_of_intersec = count($intersec);//集合の数
        $num_of_target = count($target);//比較元の母数
        $num_of_comparator = count($comparator);//比較対象の母数
        try {//Simpson係数(| X ∩ Y | / min(|X|,|Y|))を算出
            return (float)$num_of_intersec/min($num_of_target, $num_of_comparator);
        } catch (\Throwable $th) {
            return -1.0;
        }
    }

    public static function get_differences($target, $comparator, $product_counts)
    {//類似度の高い人が購入されているものの中でまだ購入していない商品を取り出す関数
        $difference_ids = array_diff(array_values(array_unique($comparator)), array_values(array_unique($target)));
        $difference_counts = [];
        foreach ($difference_ids as $difference_id) {
            array_push($difference_counts, $product_counts[$difference_id]);
        }
        $datas = array_map(null, $difference_ids, $difference_counts);
        array_multisort(array_column($datas, '1'), SORT_DESC, $datas);
        return $datas;
    }

    public static function get_reccomends($target_id)
    {//購入履歴を元にレコメンドする商品を求める(協調フィルタリングを簡単に実装したもの)
        $order_logs = Order_log::join('orders', 'orders.id', '=', 'order_id')->select('lover_id', 'product_id')->where('lover_id', '!=', null)->orderby('order_logs.id')->get();//購入系統を把握できるように、相手を一意に特定できる大切な人への購入ログのみを取得

        $lover_logs = array();//大切な人ごとにログを振り分け
        foreach ($order_logs as $order_log) {
            if (empty($lover_logs[$order_log->lover_id])) {
                $lover_logs[$order_log->lover_id] = array('items' => [],'simpson' => 0.0);
            }
            array_push($lover_logs[$order_log->lover_id]['items'], $order_log->product_id);
        }
        ksort($lover_logs);

        $order_log_counts = Order_log::join('orders', 'order_id', '=', 'orders.id')//それぞれの商品が購入された数を求める
        ->select('product_id', DB::raw('sum(count) as count'))
        ->groupBy('product_id')->orderby('product_id')->get();
        $product_counts = array();
        foreach ($order_log_counts as $order_log_count) {
            $product_counts[$order_log_count->product_id] = $order_log_count->count;
        }

        $recommend_ids = [];
        $target = $lover_logs[$target_id]['items'];//推薦する人に購入されているもの
        foreach ($lover_logs as &$lover_log) {
            $lover_log['simpson'] = BaseClass::get_simpson($target, $lover_log['items']);//それぞれの大切な人の購入履歴との類似度(Simpson係数)を算出
        }
        unset($lover_log);

        array_multisort(array_column($lover_logs, 'simpson'), SORT_DESC, $lover_logs);//類似度が高い順にソート

        $temp_array = [];
        foreach ($lover_logs as $lover_log) {
            if (count($recommend_ids) > 2 || $lover_log['simpson'] <= 0) {
                break;
            } //しレコメンドする商品が3つ選べた、もしくは類似度が0の領域に達したら終了
            $new_arrays = BaseClass::get_differences($target, $lover_log['items'], $product_counts);//類似度の高い人が購入されているものの中でまだ購入していない商品を取り出す
            foreach ($new_arrays as $new_array) {
                if (!in_array($new_array[0], $temp_array)) {//二重でレコメンドされないか確認するための配列
                    $temp_array[] = $new_array[0];
                    array_push($recommend_ids, $new_array);
                }
            }
        }
        if ($recommend_ids > 2) {//4つ以上要素があれば3つにする
            array_splice($recommend_ids, 3);
        }
        $recommend_ids = array_column($recommend_ids, '0');
        $products = new Collection();
        foreach ($recommend_ids as $recommend_id) {
            $product = Product::select('products.*')
                ->find($recommend_id);
            $products->push($product);
        }

        return $products;
    }
}
