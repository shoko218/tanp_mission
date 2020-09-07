<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function __invoke()
    {
        $user_id=Auth::user()->id;
        $lovers = Lover::join('relationships', 'relationship_id', '=', 'relationships.id')
        ->select('last_name','first_name','lovers.id','relationships.name','img_extension')
        ->where('user_id',$user_id)
        ->get();
        $param=['lovers'=>$lovers];
        return view('mypage.lovers.top',$param);
    }
}
