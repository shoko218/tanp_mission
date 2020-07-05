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
    {//仮
        // $seasonRanks = Product::join('orders', 'products.id', '=', 'orders.product_id')
        // ->join('genres', 'genres.id', '=', 'genre_id')
        // ->select('products.id','products.name as product_name','genres.name as genre','price')
        // ->groupBy('product_id')
        // ->orderByRaw('count(scene_id=7) desc')
        // ->orderByRaw('count(orders.id) desc')
        // ->orderBy('products.id', 'desc')
        // ->limit(3)
        // ->get();

        // $popularityRanks = Product::select('products.id','products.name as product_name','genres.name as genre','price')
        // ->join('genres', 'genres.id', '=', 'genre_id')
        // ->withCount('orders')
        // ->orderBy('orders_count', 'desc')
        // ->orderBy('products.id', 'desc')
        // ->limit(3)
        // ->get();

        $seasonRanks=Product::select('products.id','products.name as product_name','genres.name as genre','price')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->limit(3)
        ->get();

        $popularityRanks=$seasonRanks;

        $param=['seasonRanks'=>$seasonRanks,'popularityRanks'=>$popularityRanks];

        return view('main.index',$param);
    }
}
