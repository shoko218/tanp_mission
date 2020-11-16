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
        try {
            $lover_id=$request->lover_id;//選ばれた大切な人のidをセッションに登録
            if(Lover::find($lover_id)->user_id===Auth::user()->id){//選んだidに該当する大切な人が自分の登録した人である場合は、セッション情報にidを登録
                session()->flash('lover_id',$lover_id);
                return redirect('/purchase/fillin_info');
            }else{//そうでなければエラーをつけてリダイレクト
                return redirect('/purchase/fillin_info')->with('err_msg','エラーが発生しました。');
            }
        } catch (\Throwable $th) {
                return redirect('/purchase/fillin_info')->with('err_msg','エラーが発生しました。');
        }
    }
}
