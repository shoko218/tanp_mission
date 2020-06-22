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
    <form action="result" class="search_form">
        @csrf
        <input type="text" class="search_bar" placeholder="検索したいワードを入力" name="keyword">
        <div class="btns">
            <button type="submit">検索</button>
        </div>
    </form>
</section>
<section class="popularity_rank">
    <h2>父の日のプレゼントランキング</h2>
    <div class="rc_cards">
        @foreach ($seasonRanks as $item)
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->product_name,'genre'=>$item->genre,'price'=>$item->price])
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
        @include('components.product_card',['product_id'=>$item->id,'title'=>$item->product_name,'genre'=>$item->genre,'price'=>$item->price])
        @endforeach
    </div>
    <div class="btns">
        <button type="button" action="#">もっとみる→</button>
    </div>
</section>
@endsection

@include('layouts.footer')