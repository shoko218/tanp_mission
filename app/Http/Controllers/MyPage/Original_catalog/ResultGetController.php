<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Catalog;
use Illuminate\Support\Facades\Log;

class ResultGetController extends Controller
{
    public function __invoke(Request $request)
    {//ステータス別でカタログを取得
        try {
            $kind = $request->kind;
            $user_id = Auth::user()->id;
            switch ($kind) {
                case 0://作成中
                    $results = Catalog::select('*')
                    ->where('user_id', '=', $user_id)
                    ->where('did_send_mail', '=', false)
                    ->where('selected_id', '=', null)
                    ->orderBy('updated_at', 'desc')
                    ->get();
                    break;
                case 1://送信済み
                    $results = Catalog::select('*')
                    ->where('user_id', '=', $user_id)
                    ->where('did_send_mail', '=', true)
                    ->where('selected_id', '=', null)
                    ->orderBy('updated_at', 'desc')
                    ->get();
                    break;
                case 2://返答あり
                    $results = Catalog::select('*')
                    ->where('user_id', '=', $user_id)
                    ->where('did_send_mail', '=', true)
                    ->where('selected_id', '!=', null)
                    ->orderBy('updated_at', 'desc')
                    ->get();
                    break;
                default:
                    return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。');
            }
            $param = ['results' => $results];
        } catch (\Throwable $th) {
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。');
        }
        return $param;
    }
}
