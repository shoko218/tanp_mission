@extends('layouts.base')

@section('pagename')
    りな さんにいままであげたもの
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="gift_history">
        <h1>りな さんにいままであげたもの</h1>
        <div id="orders">
            <div id="od_cards">
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
                @include('components.order_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','date'=>'2020/04/18','person'=>'りな','event'=>'誕生日'])
            </div>
        </div>
    </section>
@endsection

@include('layouts.footer')