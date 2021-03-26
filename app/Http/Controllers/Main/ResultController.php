<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\BaseClass;
use App\Model\Scene;
use App\Model\Genre;
use App\Model\Relationship;
use App\Model\Generation;

class ResultController extends Controller
{
    public function __invoke(Request $request)//検索し、結果を表示する
    {
        $scenes = Scene::all();
        $genres = Genre::all();
        $relationships = Relationship::all();
        $generations = Generation::all();
        if (Request('keyword') == null&&Request('target_scene_id') == null&&Request('target_genre_id') == null&&Request('target_relationship_id') == null&&Request('target_gender') == null&&Request('target_generation_id') == null) {//何も条件がなければ、エラーとともに結果を表示しない検索画面に遷移する
            return redirect('/search')->with('err_msg', '検索条件を一つ以上選択してください。');
        } else {//選ばれていれば条件に基づいて検索し、検索結果を表示する
            $results = BaseClass::searchProducts(Request('keyword'), Request('target_scene_id'), Request('target_genre_id'), Request('target_relationship_id'), Request('target_gender'), Request('target_generation_id'), Request('sort_by'));
            $param = ['results' => $results,'scenes' => $scenes,'genres' => $genres,'relationships' => $relationships,'generations' => $generations];
            return view('main.result', $param);
        }
    }
}
