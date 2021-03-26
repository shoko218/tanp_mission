<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    public function __invoke(Request $request)//あらゆるメッセージを表示するためのページ表示
    {
        $title = $request->session()->get('title');
        $msg = $request->session()->get('msg');
        if ($title != null && $msg != null) {
            $param = ['title' =>$title,'msg' =>$msg];
            return view('main.msg_to_top', $param);
        } else {
            return redirect('/');
        }
    }
}
