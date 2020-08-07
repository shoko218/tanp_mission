<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Scene;
use App\Model\Relationship;
use App\Model\Genre;
use App\Model\Generation;

class SearchController extends Controller
{
    public function __invoke(){

        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();

        $param=['scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];

        return view('main.search',$param);
    }
}
