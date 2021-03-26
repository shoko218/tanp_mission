<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\EmailReset;
use App\User;
use Str;
use Illuminate\Support\Facades\Auth;


class SendMailToEditEmailProcessController extends Controller
{
    public function __invoke(Request $request){
        $validated_data = $request->validate([
            'email' => ['required', 'string', 'max:255','unique:users']
        ]);
        $new_email = $request->email;
        $token = hash_hmac(
            'sha256',
            Str::random(40) . $new_email,
            config('app.key')
        );

        DB::beginTransaction();
        try {
            $param = [];
            $param['user_id'] = Auth::id();
            $param['new_email'] = $new_email;
            $param['token'] = $token;
            $email_reset = EmailReset::create($param);

            DB::commit();

            $email_reset->sendEmailResetNotification($token);

            return redirect('/msg')->with('title', '送信完了')->with('msg', '確認メールを送信しました。');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。');
        }
    }
}
