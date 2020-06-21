<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Order;
use App\User;
use DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $seasonRanks = Product::join('orders', 'products.id', '=', 'orders.product_id')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->select('products.id','products.name as product_name','genres.name as genre','price')
        ->groupBy('product_id')
        ->orderByRaw('count(scene_id=7) desc')
        ->limit(3)
        ->get();

        $popularityRanks = Product::select('products.id','products.name as product_name','genres.name as genre','price')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->withCount('orders')
        ->orderBy('orders_count', 'desc')
        ->limit(3)
        ->get();

        $param=['seasonRanks'=>$seasonRanks,'popularityRanks'=>$popularityRanks];

        return view('main.index',$param);
    }
}
