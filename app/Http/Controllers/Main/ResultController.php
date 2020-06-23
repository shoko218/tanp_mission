<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $results = Product::select('products.id','products.name as product_name','genres.name as genre','price')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->withCount('orders')
        ->orderBy('orders_count', 'desc')
        ->orderBy('products.id', 'desc')
        ->paginate(10);
        $keyword=$request->input('keyword');
        $param=['keyword'=>$keyword,'results'=>$results];
        return view('main.result',$param);
    }
}
