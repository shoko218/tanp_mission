@extends('layouts.base')

@section('pagename')
    オリジナルカタログ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="select_product" class="normal_section">
    <h1><span class="no_wrap">{{ $catalog->user->last_name.$catalog->user->first_name }}様より、</span><span class="no_wrap">{{ $catalog->name }}様専用のカタログを</span><span class="no_wrap">お届け致します。</span></h1>
    <p><img src="/image/catalog_imgs/{{ sprintf('%05d', $catalog->img_num) }}.png" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img"></p>
    <p class="msg">お好きな商品を一つお選びください。</p>
    <h2>商品一覧</h2>
    <div class="oc_product_cards">
        @foreach ($catalog->products as $item)
            @include('components.select_product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price,'catalog_id'=>$catalog->id])
        @endforeach
    </div>
</section>
@endsection

@include('layouts.footer')