@extends('layouts.base')

@section('pagename')
    {{ $product->name }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="product_detail">
        <div id="product_header">
            <img src="{{ asset( 'image/products/'.sprintf('%05d', $product->id).'.png',true)}}" alt="" class="product_img">
            @if (Auth::check())
                <good-component :is-fav={{ $is_fav }} product-id={{ $product->id }}></good-component>
            @endif
        </div>
        <div id="product_explanation">
            <h1 class="product_name">{{ $product->name }}</h1>
            <h2 class="price">¥{{ number_format($product->price) }}(+tax)</h2>
            <form action="/cart/in" method="post" id="cart_in">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
            @if (Auth::check())
                <form action="/mypage/original_catalog/select_which_catalog" method="post" id="catalog_in">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
            @endif
            <div class="btns">
                <button type="submit" form="cart_in" class="cart_btn">カートに入れる</button>
                @if (Auth::check())
                <button type="submit" form="catalog_in" class="catalog_in_btn">カタログに追加</button>
                @endif
            </div>
            <p class="product_description">{{ $product->description }}</p>
        </div>
    </section>
@endsection

@include('layouts.footer')