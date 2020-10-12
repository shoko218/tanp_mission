@extends('layouts.base')

@section('pagename')
    トップページ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<div id="index">
    @include('components.msgs')
    <section id="banner">
        <a href="{{ config('constant.domain') }}/result?_token=SrFd4V3jQaYGSc696NP8kzwXpK6cBdhQFBJRHfwt&target_scene_id=8&target_relationship_id=6&target_genre_id=&target_gender=&target_generation_id=&sort_by=0&keyword=">
            @if (env('APP_ENV') == 'production')
                <img src="{{ Storage::disk('s3')->url('banner_imgs/banner01.png')}}" alt="バナー画像" id="banner_img">
            @else
                <img src="/image/banner_imgs/banner01.png" alt="バナー画像" id="banner_img">
            @endif
        </a>
    </section>
    <section id="search_area">
        <h1>プレゼントを探す</h1>
        @include('components.search_form')
    </section>
    <section class="popularity_rank">
        <h2>20代の方に人気のプレゼントランキング</h2>
        <div class="rc_cards">
            @foreach ($popularityRanks as $item)
            @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
            @endforeach
        </div>
        <form action="/result" id="popularity_search" method="get">
            @csrf
            <input type="hidden" name="target_generation_id" value="3">
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
    <random-recommend :product-id={{ $rand_product->id }} title={{ $rand_product->name }} genre={{ $rand_product->genre->name }} price={{ $rand_product->price }} @if(env('APP_ENV') == 'production') s3-directory={{ Storage::disk('s3')->url('products/')}}@endif></random-recommend>
    @endsection
</div>

@include('layouts.footer')