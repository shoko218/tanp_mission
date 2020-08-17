@extends('layouts.base')

@section('pagename')
    オリジナルカタログ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="original_catalog_detail" class="normal_section">
    @include('components.msgs')
    <h1>{{ $catalog->name }}さんへの<br>オリジナルカタログ</h1>
    <p><img src="{{ asset( 'image/catalog_imgs/'.sprintf('%05d', $catalog->img_num).'.png',true)}}" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img"></p>
        @if ($catalog->did_send_mail)
            @if ($selected!=null)
                <p class="reply">
                    {{ $catalog->name }}さんは<br><b>{{ $selected->name }}</b>がお好みのようです！
                </p>
                <form action="/cart/in" method="post" id="cart_in">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $selected->id }}">
                </form>
                <div class="btns">
                    <button type="submit" form="cart_in" class="cart_btn">カートに入れる</button>
                </div>
            @else
                <p class="reply">
                    {{ $catalog->name }}さんからの返信は<br>まだ届いていません。
                </p>
            @endif
        @elseif(count($catalog->products)>1)
            <form action="send_process" method="post" id="send_mail">
                @csrf
                <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
            </form>
            <div class="btns">
                <button form="send_mail" onClick="return confirm('カタログをメールで送信します。\nカタログを送ると商品の変更はできなくなりますが、よろしいですか？');">カタログの中身を決定し、カタログを送る</button>
            </div>
        @endif
    <h2>商品一覧</h2>
    @if (count($catalog->products))
        <div class="oc_product_cards">
            @foreach ($catalog->products as $item)
                @if ($catalog->did_send_mail)
                    @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
                @else
                    @include('components.catalog_product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price,'catalog_id'=>$catalog->id])
                @endif
            @endforeach
        </div>
    @else
        @include('components.nothing_msgs')
    @endif
    @if(!$catalog->did_send_mail)
        <form method="post" name="edit_form" id="edit_form" action="/mypage/original_catalog/edit">
            @csrf
            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
        </form>
        <p class="submit_a"><a href="javascript:edit_form.submit()">このカタログを編集する</a></p>
        <form method="post" name="delete_form" id="delete_form" action="/mypage/original_catalog/delete_process">
            @csrf
            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
        </form>
        <p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm('このカタログを削除します。\nよろしいですか？');">このカタログを削除する</a></p>
    @endif
</section>
@endsection

@include('layouts.footer')