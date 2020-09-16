@extends('layouts.base')

@section('pagename')
    トップページ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
@include('components.msgs')
{{-- <section id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="{{ asset( 'image/sliders/slider01.png',true)}}" alt="スライダー画像" id="slider_img">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset( 'image/sliders/slider02.png',true)}}" alt="スライダー画像" id="slider_img">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
</section> --}}
<section id="banner">
    <a href="http://tanp_mission.jp/result?_token=SrFd4V3jQaYGSc696NP8kzwXpK6cBdhQFBJRHfwt&target_scene_id=8&target_relationship_id=6&target_genre_id=&target_gender=&target_generation_id=&sort_by=0&keyword=">
        <img src="{{ asset( 'image/banner_imgs/banner01.png',true)}}" alt="バナー画像" id="banner_img">
    </a>
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

<random-recommend :product-id={{ $rand_product->id }} title={{ $rand_product->name }} genre={{ $rand_product->genre->name }} price={{ $rand_product->price }}></random-recommend>
@endsection

@include('layouts.footer')