@extends('layouts.base')

@section('pagename')
    大切な人-{{ $name }}さん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lover" class="normal_section">
        <img src="{{ asset( 'image/lover_icons/noimage.png',true)}}" alt="{{ $name }}さん" id="lover_img">
        <p id="lover_name">{{ $name }}さん</p>
        <div class="lovers_btns">
            <button onclick="location.href='/mypage/reminder/register'">イベント登録+</button>
            <form action="/mypage/lovers/gift_history" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="name" value="{{ $name }}">
                <button type="submit">今まであげたもの</button>
            </form>
        </div>
    </section>
    @if ($products!=null)
    <section class="recommend_rank">
        <h2>{{ $name }}さんにおすすめのプレゼント</h2>
        <div class="rc_cards">
            @foreach ($products as $product)
            @include('components.product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/result'">プレゼントを探しに行く→</button>
        </div>
    </section>
    @endif
@endsection

@include('layouts.footer')