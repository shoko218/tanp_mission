<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Lover;
use App\Model\Scene;
use App\Model\Prefecture;
use App\Model\Relationship;

class FillinInfoController extends Controller
{
    public function __invoke(Request $request){
        if(Auth::check()&&session('lover_id')!=null){
            $lover=Lover::where('id','=',session('lover_id'))->first();
        }else{
            $lover=null;
        }
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $lovers = Lover::select('last_name','first_name','lovers.id')
            ->where('user_id',$user_id)
            ->get();
        }else{
            $lovers=null;
        }
        $scenes = Scene::all();
        $prefectures = Prefecture::select('id','name')->get();
        $relationships = Relationship::select('id','name')->get();
        $param=['lover'=>$lover,'lovers'=>$lovers,'scenes'=>$scenes,'prefectures'=>$prefectures,'relationships'=>$relationships];
        return view('main.purchase.fillin_info',$param);
    }
}
