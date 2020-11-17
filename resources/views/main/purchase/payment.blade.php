@extends('layouts.base')

@section('pagename')
ご注文情報の確認
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="payment" class="normal_section">
@include('components.msgs')
<div class="alert alert-danger alert-dismissible fade show msg_box">
    ※このサービスはデモであり、購入処理をされても商品は届きません。<br>
    また、クレジットカードの処理決済もデモですので引き落とされることはありません。<br>
    デモ決済を行う場合は、カード番号の部分に[4242 4242 4242 4242]と入力してください。
</div>
<h1>ご注文情報の確認</h1>
<div id="orders">
    <div id="od_cards">
        @if (Auth::check())
            @foreach ($cart_goods as $cart_good)
            @include('components.confirm_product_card',['product_id'=>$cart_good->product->id,'title'=>$cart_good->product->name,'genre'=>$cart_good->product->genre->name,'price'=>$cart_good->product->price,'count'=>$cart_good->count])
            @endforeach
        @else
            @foreach ($products as $product)
            @include('components.confirm_product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price,'count'=>$product_count[$loop->iteration-1]])
            @endforeach
        @endif
    </div>
</div>
<p class="cart_sum">商品合計:<b>¥{{ number_format($sum_price) }}</b></p>
<form action="/purchase/payment_process" method="POST">
    @csrf
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{{ config('constant.pub_key') }}"
        data-amount="{{ $sum_price }}"
        data-name="決済"
        data-label="決済"
        data-description="これはデモ決済です"
        data-locale="auto"
        data-currency="JPY">
    </script>
</section>
@endsection

@include('layouts.footer')
