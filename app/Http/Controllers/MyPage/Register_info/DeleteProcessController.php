<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request){
        if(Auth::user()->email=='test@example.com'){
            return redirect('/msg')->with('title','エラー')->with('msg','テストアカウントは削除できません。');
        }else{
            User::find(Auth::user()->id)->delete();
            return redirect('/msg')->with('title','退会処理完了')->with('msg','退会処理が完了しました。');
        }
    }
}
