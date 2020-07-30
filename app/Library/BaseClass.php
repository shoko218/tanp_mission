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

    public static function searchProducts($keyword,$target_scene_id,$target_genre_id,$target_relationship_id,$target_gender,$target_generation_id,$limit=null){
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

        if ($keyword) {
            $temps=explode(" ", $keyword);
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

        if ($target_scene_id) {
            $sceneSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as scene_count_raw'))
            ->where('orders.scene_id', '=', $target_scene_id)
            ->groupBy('product_id');
            $mainQuery->joinSub($sceneSQL, 'scene_counts', 'products.id', 'scene_counts.product_id')->orderBy('scene_count_raw', 'desc');
        }

        if ($target_genre_id) {
            $mainQuery->where('products.genre_id', '=', $target_genre_id);
        }

        if ($target_relationship_id) {
            $relationshipSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as relationship_count_raw'))
            ->where('orders.relationship_id', '=', $target_relationship_id)
            ->groupBy('product_id');
            $mainQuery->joinSub($relationshipSQL, 'relationship_counts', 'products.id', 'relationship_counts.product_id')->orderBy('relationship_count_raw', 'desc');
        }

        if ($target_gender) {
            if($target_gender!=2){
                $genderSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
                ->select('product_id', DB::raw('count(*) as gender_count_raw'))
                ->where('orders.gender', '=', $target_gender)
                ->groupBy('product_id');
                $mainQuery->joinSub($genderSQL, 'gender_counts', 'products.id', 'gender_counts.product_id')->orderBy('gender_count_raw', 'desc');
            }
        }

        if ($target_generation_id) {
            $generationSQL=Order_log::join('orders', 'order_id', '=', 'orders.id')
            ->select('product_id', DB::raw('count(*) as generation_count_raw'))
            ->where('orders.generation_id', '=', $target_generation_id)
            ->groupBy('product_id');
            $mainQuery->joinSub($generationSQL, 'generation_counts', 'products.id', 'generation_counts.product_id')->orderBy('generation_count_raw', 'desc');
        }

        if($limit){
            $results=$mainQuery->limit($limit)->get();
        }else{
            $results=$mainQuery->paginate(10);
        }

        return $results;
    }

    public static function get_simpson($target,$comparator){
        $intersec=array_intersect(array_values(array_unique($target)),array_values(array_unique($comparator)));
        $num_of_intersec=count($intersec);
        $num_of_target=count($target);
        $num_of_comparator=count($comparator);
        try {
            return (float)$num_of_intersec/min($num_of_target,$num_of_comparator);
        } catch (\Throwable $th) {
            return -1.0;
        }
    }

    public static function get_differences($target,$comparator,$product_counts){
        $difference_ids=array_diff(array_values(array_unique($comparator)),array_values(array_unique($target)));
        $difference_counts=[];
        foreach ($difference_ids as $difference_id) {
            array_push($difference_counts,$product_counts[$difference_id]);
        }
        $datas=array_map(NULL,$difference_ids,$difference_counts);
        array_multisort(array_column($datas,'1'), SORT_DESC, $datas);
        return $datas;
    }

    public static function get_reccomends($target_id){
        $order_logs=Order_log::join('orders','orders.id','=','order_id')->select('lover_id','product_id')->where('lover_id','!=',NULL)->orderby('order_logs.id')->get();
        $lover_logs=array();
        foreach ($order_logs as $order_log) {
            if(empty($lover_logs[$order_log->lover_id])){
                $lover_logs[$order_log->lover_id]=array('items'=>[],'simpson'=>0.0);
            }
            array_push($lover_logs[$order_log->lover_id]['items'],$order_log->product_id);
        }
        ksort($lover_logs);

        $order_log_counts=Order_log::join('orders', 'order_id', '=', 'orders.id')
        ->select('product_id', DB::raw('sum(count) as count'))
        ->groupBy('product_id')->orderby('product_id')->get();
        $product_counts=array();
        foreach($order_log_counts as $order_log_count){
            $product_counts[$order_log_count->product_id]=$order_log_count->count;
        }

        $recommend_ids=[];
        $target=$lover_logs[$target_id]['items'];
        foreach ($lover_logs as &$lover_log) {
            $lover_log['simpson']=BaseClass::get_simpson($target,$lover_log['items']);
        }
        unset($lover_log);

        array_multisort(array_column($lover_logs, 'simpson'), SORT_DESC, $lover_logs);

        $temp_array=[];
        foreach ($lover_logs as $lover_log) {
            if(count($recommend_ids)>4||$lover_log['simpson']<=0) break;
            $new_arrays=BaseClass::get_differences($target,$lover_log['items'],$product_counts);
            foreach ($new_arrays as $new_array) {
                if(!in_array($new_array[0],$temp_array)){
                    $temp_array[]=$new_array[0];
                    array_push($recommend_ids,$new_array);
                }
            }
        }
        if($recommend_ids>4){
            array_splice($recommend_ids,5);
        }
        $recommend_ids=array_column($recommend_ids,'0');
        $products = new Collection();
        foreach ($recommend_ids as $recommend_id) {
            $product=Product::select('products.*')
            ->find($recommend_id);
            $products->push($product);
        }

        return $products;
    }

}