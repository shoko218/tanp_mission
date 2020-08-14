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
        $new_email = $request->new_email;

        if(User::where('email','=','$new_email')->get()==null){
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
                return redirect('/msg')->with('title', '送信エラー')->with('msg', 'メール更新に失敗しました。');
            }
        }else{
            return redirect('/mypage/register_info/edit_email')->with('err_msg', 'このメールアドレスは既に使用されています。')->with('new_email',$new_email);
        }
    }
}
