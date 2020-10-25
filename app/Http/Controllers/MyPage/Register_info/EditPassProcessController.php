<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EditPassProcessController extends Controller
{
    public function __invoke(Request $request){
        if(!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with('err_msg', '現在のパスワードが間違っています。');
        }

        $validated_data = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed|halfalphanum|max:256',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect('/mypage/register_info')->with('suc_msg', 'パスワードを変更しました。');
    }
}
