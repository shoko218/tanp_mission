@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="cart">
        <h1>お買い物カゴ</h1>
        @if ($products!=null)
        <div id="orders">
            <div id="od_cards">
                @foreach ($products as $product)
                @include('components.cart_product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price])
                @endforeach
            </div>
        </div>
        <div class="btns">
            <button type="button" action="#">購入手続きへ→</button>
        </div>
        @else
            <p class="cart_msg">まだ商品はありません。</p>
        @endif
    </section>
@endsection

@include('layouts.footer')