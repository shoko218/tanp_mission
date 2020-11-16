<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Model\Scene;
use App\Model\Relationship;
use App\Model\Genre;
use App\Model\Generation;

class SearchController extends Controller
{
    public function __invoke(){//結果を表示しない検索画面

        $scenes=Scene::all();
        $genres=Genre::all();
        $relationships=Relationship::all();
        $generations=Generation::all();

        $param=['scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];

        return view('main.search',$param);
    }
}
