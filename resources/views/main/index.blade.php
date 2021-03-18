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
        <a href="{{ config('constant.domain') }}/result?target_scene_id=12&sort_by=0">
            @if (env('APP_ENV') === 'production')
                <img src="{{ Storage::disk('s3')->url('banner_imgs/banner.jpg')}}" alt="バナー画像" id="banner_img">
            @else
                <img src="/image/banner_imgs/banner01.jpg" alt="バナー画像" id="banner_img">
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
        <form action="/make_result_url" id="popularity_search" method="get">
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
        <form action="/make_result_url" id="season_popularity_search" method="get">
            @csrf
            <input type="hidden" name="target_genre_id" value="1">
            <input type="hidden" name="sort_by" value="1">
        </form>
        <div class="btns">
            <button type="submit" form="season_popularity_search">もっとみる→</button>
        </div>
    </section>
    @endsection
</div>

@include('layouts.footer')
