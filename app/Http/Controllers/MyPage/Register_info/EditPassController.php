<?php

namespace App\Http\Controllers\MyPage\Register_info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditPassController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('mypage.register_info.edit_pass');
    }
}
