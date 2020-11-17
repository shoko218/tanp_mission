<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditProcessController extends Controller
{
    public function __invoke(Request $request){
        if($request->lover_id!=null){
            $lover=Lover::find($request->lover_id);
            if($lover==null||$lover->user_id!=Auth::user()->id){
                return back()->with('err_msg','エラーが発生しました。');
            }
        }else{
            return back()->with('err_msg','エラーが発生しました。');
        }
        $this->validate($request,Lover::$rules);
        DB::beginTransaction();
        try {
            $lover->fill($request->except(['lover_id','image']))->save();
            if($request->file('image')!=null){
                $file_name = uniqid(rand());//ランダムなファイル名を作成
                $path=$request->image->path();
                $image=\Image::make($path);
                $image->fit(480,480,function($constraint){//リサイズ
                    $constraint->upsize();
                });
                $old_path=$lover->img_path;
                $lover->update(['img_path'=>$file_name.'.jpg']);

                if (env('APP_ENV') === 'production') {
                    Storage::disk('s3')->put('/lover_imgs/'.$file_name.'.jpg',(string)$image->encode(),'public');
                    if($old_path!=null){
                        Storage::disk('s3')->delete('/lover_imgs/'.$old_path);//前の写真は削除
                    }
                }else{
                    $image->save('storage/lover_imgs/'.$file_name.'.jpg');
                    if($old_path!=null){
                        Storage::disk('local')->delete('public/lover_imgs/'.$old_path);//前の写真は削除
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('/mypage/lovers/'.$lover->id)->with('suc_msg','変更しました。')->with('lover_id',$request->lover_id);
    }
}
