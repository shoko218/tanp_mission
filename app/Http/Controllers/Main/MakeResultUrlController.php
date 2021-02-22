<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakeResultUrlController extends Controller
{
    public function __invoke(Request $request){ //検索URLを整形する
        $url = '/result?';
        if(Request('keyword') != null){
            $url = $url.'keyword='.Request('keyword').'&';
        }else{
            if(Request('target_scene_id') != null){//シーン
                $url = $url.'target_scene_id='.Request('target_scene_id').'&';
            }
            if(Request('target_genre_id') != null){//ジャンル
                $url = $url.'target_genre_id='.Request('target_genre_id').'&';
            }
            if(Request('target_relationship_id') != null){//関係性
                $url = $url.'target_relationship_id='.Request('target_relationship_id').'&';
            }
            if(Request('target_gender') != null){//性別
                $url = $url.'target_gender='.Request('target_gender').'&';
            }
            if(Request('target_generation_id') != null){//世代
                $url = $url.'target_generation_id='.Request('target_generation_id').'&';
            }
        }
        if(Request('sort_by') === null){
            $url = $url.'sort_by=0';
        }else{
            $url = $url.'sort_by='.Request('sort_by');//ソート
        }
        return redirect($url);
    }
}
