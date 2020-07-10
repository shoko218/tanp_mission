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
use App\User;
use DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $seasonRanks=Product::select('products.id','products.name as product_name','genres.name as genre','price')
        ->join('genres', 'genres.id', '=', 'genre_id')
        ->limit(3)
        ->get();

        $popularityRanks=$seasonRanks;

        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();

        $param=['seasonRanks'=>$seasonRanks,'popularityRanks'=>$popularityRanks,'scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];

        return view('main.index',$param);
    }
}
