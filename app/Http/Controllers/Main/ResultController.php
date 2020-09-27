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
        if(Request('keyword')==null&&Request('target_scene_id')==null&&Request('target_genre_id')==null&&Request('target_relationship_id')==null&&Request('target_gender')==null&&Request('target_generation_id')==null){
            return redirect('/search')->with('err_msg','検索条件を一つ以上選択してください。');
        }else{
            $results=BaseClass::searchProducts(Request('keyword'),Request('target_scene_id'),Request('target_genre_id'),Request('target_relationship_id'),Request('target_gender'),Request('target_generation_id'),Request('sort_by'));
            $param=['results'=>$results,'scenes'=>$scenes,'genres'=>$genres,'relationships'=>$relationships,'generations'=>$generations];
            return view('main.result',$param);
        }
    }
}
