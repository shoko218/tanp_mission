<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $catalog = Catalog::find($request->catalog_id);//存在しないカタログidが指定されていたらエラー
            if ($catalog == null) {
                return redirect('mypage/original_catalog/')->with('err_msg', 'エラーが発生しました。');
            }
            if ($catalog->did_send_mail) {
                return redirect('mypage/original_catalog/')->with('err_msg', '既に相手に送っているカタログは削除できません。');
            }
            $catalog->delete();
            return redirect('mypage/original_catalog/')->with('suc_msg', '削除しました。');
        } catch (\Throwable $th) {
            return back()->with('err_msg', 'エラーが発生しました。');
        }
    }
}
