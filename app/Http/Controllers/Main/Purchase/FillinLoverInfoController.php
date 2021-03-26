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
    public function __invoke(Request $request)
    {
        try {
            if ($request->selected_lover_id == null) {//いいえが選ばれた場合
                session()->flash('selected_lover_id', null);
                return redirect('/purchase/fillin_info');
            } else {//大切な人が選ばれている場合
                $selected_lover_id = $request->selected_lover_id; //選ばれた大切な人のidをセッションに登録
                $lover = Lover::find($selected_lover_id);
                if ($lover != null && $lover->user_id === Auth::user()->id) {//大切な人が取得できており、かつ選んだidに該当する大切な人が自分の登録した人である場合は、セッション情報にidを登録
                    session()->flash('selected_lover_id', $selected_lover_id);
                    return redirect('/purchase/fillin_info');
                } else {//そうでなければエラーをつけてリダイレクト
                    return redirect('/purchase/fillin_info')->with('err_msg', 'エラーが発生しました。');
                }
            }
        } catch (\Throwable $th) {
            return redirect('/purchase/fillin_info')->with('err_msg', 'エラーが発生しました。');
        }
    }
}
