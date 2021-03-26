<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\User;

class EditEmailProcessController extends Controller
{
    public function __invoke(Request $request, $token)
    {
        $email_resets = DB::table('email_resets')
            ->where('token', $token)
            ->first();

        $expires = 60 * 60;
        if ($email_resets && !Carbon::parse($email_resets->created_at)->addSeconds($expires)->isPast()) {
            $user = User::find($email_resets->user_id);
            $user->email = $email_resets->new_email;
            $user->save();

            DB::table('email_resets')
                ->where('token', $token)
                ->delete();

            return redirect('/msg')->with('title', 'メールアドレス更新完了')->with('msg', 'メールアドレスを更新しました！');
        } else {
            if ($email_resets) {
                DB::table('email_resets')
                    ->where('token', $token)
                    ->delete();
            }
            return redirect('/msg')->with('title', 'メールアドレス更新失敗')->with('msg', 'メールアドレスの更新に失敗しました。');
        }
    }
}
