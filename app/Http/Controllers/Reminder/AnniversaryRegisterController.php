<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnniversaryRegisterController extends Controller
{
    public function __invoke()
    {
        return view('mypage.reminder.anniversary_register');
    }
}
