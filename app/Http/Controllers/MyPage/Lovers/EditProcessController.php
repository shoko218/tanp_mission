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
        $this->validate($request,Lover::$rules);
        DB::beginTransaction();
        try {
            $lover=Lover::find($request->lover_id);
            $lover->fill($request->except(['lover_id','image']))->save();
            if($request->file('image')!=null){
                $base_name = $request->file('image')->getClientOriginalName();
                $file_name = uniqid(rand());//ランダムなファイル名を作成
                $path=$request->image->path();
                $image=\Image::make($path);
                $image->fit(480,480,function($constraint){//リサイズ
                    $constraint->upsize();
                });
                $old_path=$lover->img_path;
                if (env('APP_ENV') === 'production') {
                    Storage::disk('s3')->put('/lover_imgs/'.$file_name.'.jpg',(string)$image->encode(),'public');
                    $lover->img_path=$file_name.'.jpg';
                    if($old_path!=null){
                        Storage::disk('s3')->delete('/lover_imgs/'.$old_path);//前の写真は削除
                    }
                }else if(env('APP_ENV') === 'local'){
                    $image->save('storage/lover_imgs/'.$file_name.'.jpg');
                    $lover->img_path=$file_name.'.jpg';
                    if($old_path!=null){
                        Storage::disk('local')->delete('public/lover_imgs/'.$old_path);//前の写真は削除
                    }
                }else if(env('APP_ENV') === 'testing'){
                    Storage::disk('fake')->put('/lover_imgs/'.$base_name,(string)$image->encode(),'public');
                    $lover->img_path = $base_name;
                    if($old_path!=null){
                        Storage::disk('fake')->delete('/lover_imgs/'.$old_path);//前の写真は削除
                    }
                }
                $lover->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('/mypage/lovers/'.$lover->id)->with('suc_msg','変更しました。')->with('lover_id',$request->lover_id);
    }
}
