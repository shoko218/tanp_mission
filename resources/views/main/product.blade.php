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
                <form action="product/<?php if($is_fav){echo "unfavorite";}else{echo "favorite";}?>" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button id="fav_btn" class="<?php if($is_fav){echo "favorite";}else{echo "unfavorite";}?>"></button>
                </form>
            @endif

        </div>
        <div id="product_explanation">
            <h1 class="product_name">{{ $product->name }}</h1>
            <h2 class="price">¥{{ number_format($product->price) }}</h2>
            <div class="btns">
                <form action="cart/in" method="post">
                    @csrf
                    @if (Auth::check())
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endif
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button class="cart_btn">カートに入れる</button>
                </form>
            </div>
            <p class="product_description">{{ $product->description }}</p>
        </div>
    </section>
@endsection

@include('layouts.footer')