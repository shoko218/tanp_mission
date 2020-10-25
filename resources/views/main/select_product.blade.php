@extends('layouts.base')

@section('pagename')
    オリジナルカタログ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="select_product" class="normal_section">
    @include('components.msgs')
    <div id="catalog_top">
        <div id="catalog_header">
            @if (env('APP_ENV') == 'production')
                <img src="{{ Storage::disk('s3')->url('catalog_imgs/'.sprintf('%05d', $catalog->img_num).'.png')}}" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img">
            @else
                <img src="/image/catalog_imgs/{{ sprintf('%05d', $catalog->img_num) }}.png" alt="{{ $catalog->name }}さんへのギフトカタログのイメージ画像" class="oc_detail_img">
            @endif
        </div>
        <div id="catalog_explanation">
            <h1><span class="no_wrap">{{ $catalog->user->last_name.$catalog->user->first_name }}様より、</span><span class="no_wrap">{{ $catalog->name }}様専用の</span><span class="no_wrap">カタログを</span><span class="no_wrap">お届け致します。</span></h1>
            <p class="msg"><span class="no_wrap">お好きな商品を</span><span class="no_wrap">一つお選びください。</span></p>
        </div>
    </div>
    <div id="calatog_description">
        <h2>商品一覧</h2>
        <div class="oc_product_cards">
            @foreach ($catalog->products as $item)
                @include('components.select_product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price,'url_str'=>$catalog->url_str])
            @endforeach
        </div>
    </div>
</section>
@endsection

@include('layouts.footer')