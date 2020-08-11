@extends('layouts.base')

@section('pagename')
    トップページ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
@include('components.msgs')
<section id="slider">
    <img src="{{ asset( 'image/sliders/slider01.png',true)}}" alt="スライダー画像" id="slider_img">
</section>
<section id="search_area">
    <h1>プレゼントを探す</h1>
    @include('components.search_form')
</section>
<section class="popularity_rank">
    <h2>人気プレゼントランキング</h2>
    <div class="rc_cards">
        @foreach ($popularityRanks as $item)
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
        @endforeach
    </div>
    <form action="/result" id="popularity_search" method="get">
        @csrf
        <input type="hidden" name="sort_by" value="1">
    </form>
    <div class="btns">
        <button type="submit" form="popularity_search">もっとみる→</button>
    </div>
</section>
<section class="popularity_rank">
    <h2>グルメプレゼントランキング</h2>
    <div class="rc_cards">
        @foreach ($seasonRanks as $item)
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
        @endforeach
    </div>
    <form action="/result" id="season_popularity_search" method="get">
        @csrf
        <input type="hidden" name="target_genre_id" value="1">
        <input type="hidden" name="sort_by" value="1">
    </form>
    <div class="btns">
        <button type="submit" form="season_popularity_search">もっとみる→</button>
    </div>
</section>
<section id="random_recommend">
    <div class="description">
        <h2>ランダムレコメンド</h2>
        <p class="comment">こんな商品はいかがですか？</p>
    </div>
    <p class="reload_btn"><a href="" onclick="location.reload();return false"><i class="fas fa-sync-alt"></i></a></p>
    @include('components.product_card',['product_id'=>$rand_product->id,'title'=>$rand_product->name,'genre'=>$rand_product->genre->name,'price'=>$rand_product->price])
</section>
@endsection

@include('layouts.footer')