@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="cart" class="normal_section">
        <div class="alert alert-danger alert-dismissible fade show msg_box">
            ※このサービスはデモであり、購入処理をされても商品は届きません。<br>
            また、クレジットカードの処理決済もデモですので引き落とされることはありません。
        </div>
        <h1>お買い物カゴ</h1>
        @if (!count($products)==0||!count($cart_goods)==0)
        <cart-component :products='@json($products)' :cart-goods='@json($cart_goods)' :sum-price='@json($sum_price)' :product-count='@json($product_count)'></cart-component>
        @else
        @include('components.nothing_msgs')
        @endif
    </section>
@endsection

@include('layouts.footer')
