<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class EditProcessController extends Controller
{
    public function __invoke(Request $request){
        $this->validate($request,User::$except_mail_pass_rules);
        User::find(Auth::user()->id)->fill($request->all())->save();
        return redirect('/mypage/register_info')->with('suc_msg','登録情報を変更しました。');
    }
}
