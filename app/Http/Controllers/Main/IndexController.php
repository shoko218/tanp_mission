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

class IndexController extends Controller
{
    public function __invoke()//トップぺージ表示
    {
        $popularityRanks = BaseClass::searchProducts(null, null, null, null, null, 3, 0, 3);//今は20代人気ランキング

        $seasonRanks = BaseClass::searchProducts(null, null, 1, null, null, null, 1, 3);//今はグルメプレゼントランキング

        $rand_product = Product::where('id', '=', rand(1, Product::count()))->first();

        $scenes = Scene::all();
        $genres = Genre::all();
        $relationships = Relationship::all();
        $generations = Generation::all();

        $param = ['popularityRanks' => $popularityRanks,'seasonRanks' => $seasonRanks,'scenes' => $scenes,'genres' => $genres,'relationships' => $relationships,'generations' => $generations,'rand_product' => $rand_product];

        return view('main.index', $param);
    }
}
