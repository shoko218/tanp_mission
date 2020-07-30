<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Generation;
use App\Model\Genre;
use App\Model\Product;
use App\Model\Order;
use App\Model\Relationship;
use App\Model\Scene;
use App\Library\BaseClass;
use App\User;
use DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $countSQL=DB::table('order_logs')
        ->join('orders', 'order_id', '=', 'orders.id')
        ->select('product_id', DB::raw('sum(count) as count'))
        ->groupBy('product_id');

        $popularityRanks=Product::select('products.*')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->leftJoinSub($countSQL, 'counts', 'products.id', 'counts.product_id')
        ->orderby('count')
        ->limit(3)
        ->get();

        $seasonRanks=BaseClass::searchProducts(null,null,1,null,null,null,3);

        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();

        $param=['popularityRanks'=>$popularityRanks,'seasonRanks'=>$seasonRanks,'scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];

        return view('main.index',$param);
    }
}
