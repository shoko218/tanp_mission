<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogReplyNotificationMail;

class SelectProductProcessController extends Controller
{
    public function __invoke(Request $request){
        $catalog=Catalog::select('*')->where('id','=',$request->session()->get('catalog_id'))->first();
        if($catalog->selected_id==null){
            Catalog::where('id','=',$request->session()->get('catalog_id'))->update(['selected_id'=>$request->product_id]);
            Mail::to($catalog->user->email)->send(new CatalogReplyNotificationMail($catalog));
            return redirect('/msg')->with('title','送信完了')->with('msg','送信しました。');
        }else{
            return redirect('/msg')->with('title','選択済み')->with('msg','既に選択されています。');
        }
    }
}
