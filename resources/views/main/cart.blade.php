@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="cart">
        <h1>お買い物カゴ</h1>
        <div id="orders">
            <div id="od_cards">
                @include('components.product_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
                @include('components.product_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
                @include('components.product_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
            </div>
        </div>
        <div class="btns">
            <button type="button" action="#">購入手続きへ→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')