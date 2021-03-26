<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EditPassProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect('/mypage/register_info/edit_pass_process')->with('err_msg', '現在のパスワードが間違っています。');
        }

        $validated_data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|halfalphanum|max:256',
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect('/mypage/register_info')->with('suc_msg', 'パスワードを変更しました。');
    }
}
