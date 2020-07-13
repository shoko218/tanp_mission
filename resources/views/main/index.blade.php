@extends('layouts.base')

@section('pagename')
    トップページ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="slider">
    <img src="{{ asset( 'image/sliders/slider01.png',true)}}" alt="スライダー画像" id="slider_img">
</section>
<section id="search_area">
    <h1>プレゼントを探す</h1>
    @include('components.search_form')
</section>
<section class="popularity_rank">
    <h2>父の日のプレゼントランキング</h2>
    <div class="rc_cards">
        @foreach ($seasonRanks as $item)
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
        @endforeach
    </div>
    <div class="btns">
        <button type="button" action="#">もっとみる→</button>
    </div>
</section>
<section class="popularity_rank">
    <h2>人気プレゼントランキング</h2>
    <div class="rc_cards">
        @foreach ($popularityRanks as $item)
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->name,'genre'=>$item->genre->name,'price'=>$item->price])
        @endforeach
    </div>
    <div class="btns">
        <button type="button" action="#">もっとみる→</button>
    </div>
</section>
@endsection

@include('layouts.footer')