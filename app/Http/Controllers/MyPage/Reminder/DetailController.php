<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function __invoke()
    {
        return view('mypage.reminder.reminder_detail');
    }
}
