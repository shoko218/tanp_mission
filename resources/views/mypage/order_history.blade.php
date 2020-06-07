@extends('layouts.base')

@section('pagename')
    注文履歴
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="order_history">
        <h1>注文履歴</h1>
        <div id="orders">
            <div id="od_cards">
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'母','event'=>'誕生日'])
            </div>
        </div>
    </section>
@endsection

@include('layouts.footer')