<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Scene;
use App\Model\Lover;

class PostRegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        return redirect('/mypage/reminder/register')->with('selected_lover_id',$request->lover_id);
    }
}
