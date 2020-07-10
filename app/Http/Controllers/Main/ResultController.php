<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Library\BaseClass;
use App\Model\Scene;
use App\Model\Genre;
use App\Model\Relationship;
use App\Model\Generation;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();
        $param=BaseClass::searchProducts();
        $param2=['scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];
        return view('main.result',$param,$param2);
    }
}
