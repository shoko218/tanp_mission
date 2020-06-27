@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="order_history">
        <h1>お気に入り</h1>
        <div id="orders">
            <div id="od_cards">
                @foreach ($favorite_products as $favorite_product)
                @include('components.product_card',['product_id'=>$favorite_product->id,'title'=>$favorite_product->name,'genre'=>$favorite_product->genre->name,'price'=>$favorite_product->price])
                @endforeach
            </div>
            {{ $favorite_products->links() }}
        </div>
    </section>
@endsection

@include('layouts.footer')