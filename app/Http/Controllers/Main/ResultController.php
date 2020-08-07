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
        $results=BaseClass::searchProducts(Request('keyword'),Request('target_scene_id'),Request('target_genre_id'),Request('target_relationship_id'),Request('target_gender'),Request('target_generation_id'),Request('sort_by'));
        $param=['results'=>$results,'scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];
        return view('main.result',$param);
    }
}
