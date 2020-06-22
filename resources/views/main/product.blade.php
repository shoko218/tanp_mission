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
            <button class="fav_btn"></button>
        </div>
        <div id="product_explanation">
            <h1 class="product_name">{{ $product->name }}</h1>
            <h2 class="price">¥{{ number_format($product->price) }}</h2>
            <div class="btns">
                <button class="cart_btn">カートに入れる</button>
            </div>
            <p>{{ $product->description }}</p>
        </div>
    </section>
@endsection

@include('layouts.footer')