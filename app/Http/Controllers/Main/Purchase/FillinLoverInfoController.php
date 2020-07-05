<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use App\Model\Scene;
use App\Model\Prefecture;
use App\Model\Relationship;
use Illuminate\Support\Facades\Auth;

class FillinLoverInfoController extends Controller
{
    public function __invoke(Request $request){
        if($request->lover_id==null){
            return redirect('/purchase/fillin_info');
        }
        $user_id=Auth::user()->id;
        $lover=Lover::where('id',$request->lover_id)->first();
        $lovers = Lover::select('last_name','first_name','lovers.id')
        ->where('user_id',$user_id)
        ->get();
        $scenes = Scene::all();
        $prefectures = Prefecture::select('id','name')->get();
        $relationships = Relationship::select('id','name')->get();
        $param=['lovers'=>$lovers,'lover'=>$lover,'scenes'=>$scenes,'prefectures'=>$prefectures,'relationships'=>$relationships];
        return view('main.purchase.fillin_lover_info',$param);
    }
}
