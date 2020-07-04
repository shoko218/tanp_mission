@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="cart">
        <h1>お買い物カゴ</h1>
        @if ($products!=null||$cart_goods!=null)
        <div id="orders">
            <div id="od_cards">
                @if (Auth::check())
                    @foreach ($cart_goods as $cart_good)
                    @include('components.cart_product_card',['product_id'=>$cart_good->product->id,'title'=>$cart_good->product->name,'genre'=>$cart_good->product->genre->name,'price'=>$cart_good->product->price,'count'=>$cart_good->count])
                    @endforeach
                @else
                    @foreach ($products as $product)
                    @include('components.cart_product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price,'count'=>$product_count[$loop->iteration-1]])
                    @endforeach
                @endif
            </div>
        </div>
        <p class="cart_sum">商品合計:<b>¥{{ number_format($sum_price) }}</b></p>
        <div class="btns">
            <button type="submit" action="#">購入手続きへ→</button>
        </div>
        @else
            <p class="cart_msg">まだ商品はありません。</p>
        @endif
    </section>
@endsection

@include('layouts.footer')