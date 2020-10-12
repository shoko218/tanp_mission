@extends('layouts.base')

@section('pagename')
    {{ $product->name }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="product_detail">
        <div id="product_top">
            <div id="product_header">
                @if (env('APP_ENV') == 'production')
                    <img src="{{ Storage::disk('s3')->url('products/'.sprintf('%05d', $product->id).'.png')}}" alt="{{ $product->title }}" class="product_img">
                @else
                    <img src="/image/products/{{ sprintf('%05d', $product->id) }}.png" alt="{{ $product->title }}" class="product_img">
                @endif
                @if (Auth::check())
                    <good-component :is-fav='@json($is_fav)' product-id='@json($product->id)'></good-component>
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
            </div>
        </div>
        <div id="product_description">
            <p>{{ $product->description }}</p>
        </div>
    </section>
@endsection

@include('layouts.footer')