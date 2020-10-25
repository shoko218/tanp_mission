@extends('layouts.base')

@section('pagename')
    オリジナルカタログ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="original_catalog_detail" class="normal_section">
    @include('components.msgs')
    <div id="catalog_top">
        <div id="catalog_header">
            @if (env('APP_ENV') == 'production')
                <img src="{{ Storage::disk('s3')->url('catalog_imgs/'.sprintf('%05d', $catalog->img_num).'.jpg')}}" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img">
            @else
                <img src="/image/catalog_imgs/{{ sprintf('%05d', $catalog->img_num) }}.jpg" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img">
            @endif
        </div>
        <div id="catalog_explanation">
            <h1>{{ $catalog->name }}さんへの<br>オリジナルカタログ</h1>
            @if ($catalog->did_send_mail)
                @if ($selected!=null)
                    <p class="reply">
                        {{ $catalog->name }}さんは<br><b>{{ $selected->name }}</b>が<span class="no_wrap">お好みのようです！</span>
                    </p>
                    <form action="/cart/in" method="post" id="cart_in">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $selected->id }}">
                    </form>
                    <div class="btns">
                        <button type="submit" form="cart_in" class="cart_btn" onclick="gtag('event','click', {'event_category': 'link','event_label': 'カタログへの回答からカートイン'});">カートに入れる</button>
                    </div>
                @else
                    <p class="reply">
                        <span class="no_wrap">{{ $catalog->name }}さんからの</span><span class="no_wrap">返信は</span><span class="no_wrap">まだ届いていません。</span>
                    </p>
                @endif
            @elseif(count($catalog->products)>1)
                <form action="send_process" method="post" id="send_mail">
                    @csrf
                    <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                </form>
                <div class="btns">
                    <button form="send_mail" onClick="return confirm('カタログをメールで送信します。\nカタログを送ると商品の変更はできなくなりますが、よろしいですか？');">カタログの中身を決定し、<span class="no_wrap">カタログを送る<span></button>
                </div>
            @endif
        </div>
    </div>
    <div id="catalog_description">
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
            @if($catalog->did_send_mail==false)
                <div class="btns">
                    <button onclick="location.href='/search'">商品を探しに行く→</button>
                </div>
            @endif
        @else
            @include('components.nothing_msgs')
        @endif
        @if(!$catalog->did_send_mail)
            <div class="change_actions">
                <p class="submit_a"><a href="/mypage/original_catalog/{{ $catalog->id }}/edit">このカタログを編集する</a></a>
                <form method="post" name="delete_form" id="delete_form" action="/mypage/original_catalog/delete_process">
                    @csrf
                    <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                </form>
                <p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm('このカタログを削除します。\nよろしいですか？');">このカタログを削除する</a></p>
            </div>
        @endif
    </div>
</section>
@endsection

@include('layouts.footer')