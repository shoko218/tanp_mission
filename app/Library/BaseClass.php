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


class BaseClass{
    public static function getProductsFromDB(){
        $user_id=Auth::user()->id;
        $cart_goods=Cart::join('products','products.id','=','product_id')
            ->select(DB::raw('carts.*'))
            ->where('user_id','=',$user_id)
            ->get();
        return $cart_goods;
    }

    public static function getProductsFromCookie(){
        $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
        $product_notdup_ids=array_values(array_unique($product_ids));
        $products = new Collection();
        $product_count=array();
        foreach ($product_notdup_ids as $product_notdup_id) {
            $product=Product::select(DB::raw('products.*'))
            ->where('id','=',$product_notdup_id)
            ->first();
            $products->push($product);
        }
        foreach ($product_notdup_ids as $product_notdup_id) {
            $temp_count=0;
            foreach ($product_ids as $product_id) {
                if($product_notdup_id==$product_id){
                    $temp_count++;
                }
            }
            $product_count[]=$temp_count;
        }
        return array($products,$product_count);
    }

    public static function calcPriceInTaxFromDB($cart_goods){
        $sum_price=0.0;
        foreach ($cart_goods as $cart_good) {
            if ($cart_good->product->genre_id==1) {
                $sum_price+=$cart_good->product->price*$cart_good->count*1.08;
            }else{
                $sum_price+=$cart_good->product->price*$cart_good->count*1.1;
            }
        }
        return $sum_price;
    }

    public static function calcPriceInTaxFromCookie($products,$product_count){
        $sum_price=0.0;
        foreach ($products as $key => $product) {
            if($product->genre_id==1){
                $sum_price+=$product->price*$product_count[$key]*1.08;
            }else{
                $sum_price+=$product->price*$product_count[$key]*1.1;
            }
        }
        return $sum_price;
    }

    public static function searchProducts(){
        $sortBy="recomend";
        $countSQL=DB::table('order_logs')
        ->join('orders', 'order_id', '=', 'orders.id')
        ->select('product_id', DB::raw('sum(count) as count'))
        ->groupBy('product_id');

        $mainQuery = Product::leftJoinSub($countSQL, 'counts', 'products.id', 'counts.product_id')->select('products.*', 'counts.count as count');

        switch ($sortBy) {
            case 'new':
                $mainQuery->orderBy('products.id', 'desc');
                break;
            case 'popular':
                $mainQuery->orderBy('products.count', 'desc');
                break;
            case 'recomend':
                break;
            default:
                break;
            }

        if (request('keyword')) {
            $temps=explode(" ", request('keyword'));
            $keywords=[];
            foreach ($temps as $key =>$temp) {
                $keywords[$key]=array(
                "normal"=>$temp,
                "hiragana"=>mb_convert_kana($temp, "c"),
                "katakana"=>mb_convert_kana($temp, "C"),
                "lower"=>strtolower($temp),
                "upper"=>strtoupper($temp),
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
        }

        if (request('target_scene_id')) {
            $sceneSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as scene_count_row'))
            ->where('orders.scene_id', '=', request('target_scene_id'))
            ->groupBy('product_id');
            $mainQuery->joinSub($sceneSQL, 'scene_counts', 'products.id', 'scene_counts.product_id')->orderBy('scene_count_row', 'desc');
        }

        if (request('target_genre_id')) {
            $mainQuery->where('products.genre_id', '=', request('target_genre_id'));
        }

        if (request('target_relationship_id')) {
            $sceneSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as relationship_count_row'))
            ->where('orders.relationship_id', '=', request('target_relationship_id'))
            ->groupBy('product_id');
            $mainQuery->joinSub($sceneSQL, 'relationship_counts', 'products.id', 'relationship_counts.product_id')->orderBy('relationship_count_row', 'desc');
        }

        if (request('target_gender')) {
            if(request('target_gender')!=2){
                $genderSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
                ->select('product_id', DB::raw('count(*) as gender_count_row'))
                ->where('orders.gender', '=', request('target_gender'))
                ->groupBy('product_id');
                $mainQuery->joinSub($sceneSQL, 'gender_counts', 'products.id', 'gender_counts.product_id')->orderBy('gender_count_row', 'desc');
            }
        }

        if (request('target_generation_id')) {
            $generationSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as generation_count_row'))
            ->where('orders.generation_id', '=', request('target_generation_id'))
            ->groupBy('product_id');
            $mainQuery->joinSub($generationSQL, 'generation_counts', 'products.id', 'generation_counts.product_id')->orderBy('generation_count_row', 'desc');
        }

        $results=$mainQuery->paginate(10);

        $param=[
        'results'=>$results,
        'keyword'=>request('keyword'),
        'target_gender'=>request('target_gender'),
        'target_genre_id'=>request('target_genre_id'),
        'target_generation_id'=>request('target_generation_id'),
        'target_scene_id'=>request('target_scene_id'),
        'target_relationship_id'=>request('target_relationship_id'),
        ];
        return $param;
    }
}