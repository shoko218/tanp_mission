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

        $popularityRanks=BaseClass::searchProducts(null,null,null,null,null,null,1,3);

        $seasonRanks=BaseClass::searchProducts(null,null,1,null,null,null,1,3);

        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();

        $param=['popularityRanks'=>$popularityRanks,'seasonRanks'=>$seasonRanks,'scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];

        return view('main.index',$param);
    }
}
