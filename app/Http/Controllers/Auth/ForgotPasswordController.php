<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkResponse(Request $request, $response)
    {
        return redirect('/msg')->with('title','送信完了')->with('msg','メールを送信しました。');
    }

    public function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->with('err_msg','エラーが発生しました。時間を開けてもう一度お試しください。');
    }
}
