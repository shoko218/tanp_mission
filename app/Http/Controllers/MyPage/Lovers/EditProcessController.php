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
        $lover=Lover::find($request->lover_id);
        $lover->fill($request->except(['lover_id','image']))->save();
        if($request->file('image')!=null){
            $file_ex = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/lover_imgs/',sprintf('%09d', $lover->id).'.'.$file_ex);
            $lover->update(['img_extension'=>$file_ex]);
        }
        $request->session()->forget('lover_id');
        return redirect('mypage/lovers/lover')->with('suc_msg','変更しました。')->with('lover_id',$request->lover_id);
    }
}
