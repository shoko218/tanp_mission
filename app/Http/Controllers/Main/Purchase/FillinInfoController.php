<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use App\Library\BaseClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Lover;
use App\Model\Scene;
use App\Model\Prefecture;
use App\Model\Relationship;
use Illuminate\Support\Facades\Cookie;

class FillinInfoController extends Controller
{
    public function __invoke(Request $request){
        if((Auth::check() && BaseClass::getProductsFromDBCart()->isEmpty()) || (!Auth::check() && Cookie::get('cart_product_ids')==null)){//ログイン状況に応じたカート内に商品があるか調べる なければカート画面に遷移
            return redirect('/cart');
        }
        try {
            if(Auth::check()&&session('selected_lover_id')!=null&&Lover::find(session('selected_lover_id'))!=null&&Lover::find(session('selected_lover_id'))->user_id===Auth::user()->id){ //会員で、自分が登録している大切な人を送り先に指定していていれば大切な人の登録情報を取得(フィルインに利用)
                $selected_lover=Lover::find(session('selected_lover_id'));
            }else{
                $selected_lover=null;
            }

            if(Auth::check()){//会員登録しているならば大切な人一覧を取得
                $lovers = Lover::select('last_name','first_name','lovers.id')
                ->where('user_id',Auth::user()->id)
                ->get();
            }else{
                $lovers=null;
            }

            $scenes = Scene::all();
            $prefectures = Prefecture::select('id','name')->get();
            $relationships = Relationship::select('id','name')->get();

            $param=['selected_lover'=>$selected_lover,'lovers'=>$lovers,'scenes'=>$scenes,'prefectures'=>$prefectures,'relationships'=>$relationships];
            return view('main.purchase.fillin_info',$param);
        } catch (\Throwable $th) {
            return back()->with('err_msg','エラーが発生しました。');
        }
    }
}
