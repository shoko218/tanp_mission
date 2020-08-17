<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use Illuminate\Http\Request;

class EditProcessController extends Controller
{
    public function __invoke(Request $request){
        session()->flash('lover_id',$request->lover_id);
        $this->validate($request,Lover::$rules);
        Lover::find($request->lover_id)->fill($request->except(['lover_id']))->save();
        $request->session()->forget('lover_id');
        return redirect('mypage/lovers/lover')->with('suc_msg','変更しました。')->with('lover_id',$request->lover_id);
    }
}
