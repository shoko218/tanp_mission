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
    <input type="hidden" value="{{ Session::get('forwarding_last_name') }}" name="last_name">
    <input type="hidden" value="{{ Session::get('forwarding_first_name') }}" name="first_name">
    <input type="hidden" value="{{ Session::get('forwarding_last_name_furigana') }}" name="last_name_furigana">
    <input type="hidden" value="{{ Session::get('forwarding_first_name_furigana') }}" name="first_name_furigana">
    <input type="hidden" value="{{ Session::get('forwarding_postal_code') }}" name="postal_code">
    <input type="hidden" value="{{ Session::get('forwarding_prefecture_id') }}" name="prefecture_id">
    <input type="hidden" value="{{ Session::get('forwarding_address') }}" name="address">
    <input type="hidden" value="{{ Session::get('forwarding_telephone') }}" name="telephone">
    @if (Session::get('gender')!=null)
        <input type="hidden" value="{{ Session::get('gender') }}" name="gender">
    @endif
    @if (Session::get('relationship_id')!=null)
        <input type="hidden" value="{{ Session::get('relationship_id') }}" name="relationship_id">
    @endif
    @if (Session::get('age')!=null)
        <input type="hidden" value="{{ Session::get('age') }}" name="age">
    @endif
    @if (Session::get('scene_id')!=null)
        <input type="hidden" value="{{ Session::get('scene_id') }}" name="scene_id">
    @endif
    @if (Session::get('user_id')!=null)
        <input type="hidden" value="{{ Session::get('user_id') }}" name="user_id">
    @endif
    @if (Session::get('lover_id')!=null)
        <input type="hidden" value="{{ Session::get('lover_id') }}" name="lover_id">
    @endif
    <input type="hidden" value="{{ Session::get('user_last_name') }}" name="user_last_name">
    <input type="hidden" value="{{ Session::get('user_first_name') }}" name="user_first_name">
    <input type="hidden" value="{{ Session::get('user_last_name_furigana') }}" name="user_last_name_furigana">
    <input type="hidden" value="{{ Session::get('user_first_name_furigana') }}" name="user_first_name_furigana">
    <input type="hidden" value="{{ Session::get('user_postal_code') }}" name="user_postal_code">
    <input type="hidden" value="{{ Session::get('user_prefecture_id') }}" name="user_prefecture_id">
    <input type="hidden" value="{{ Session::get('user_address') }}" name="user_address">
    <input type="hidden" value="{{ Session::get('user_email') }}" name="user_email">
    <input type="hidden" value="{{ Session::get('user_telephone') }}" name="user_telephone">
    <input type="hidden" value="{{ $sum_price }}" name="sum_price">
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
