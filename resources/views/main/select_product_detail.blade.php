@extends('layouts.base')

@section('pagename')
    {{ $product->name }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="select_product_detail">
        <div id="product_top">
            <div id="product_header">
                <img src="{{ asset( 'image/products/'.sprintf('%05d', $product->id).'.png',true)}}" alt="" class="product_img">
            </div>
            <div id="product_explanation">
                <h1 class="product_name">{{ $product->name }}</h1>
                <form action="/select_product_process" method="post" id="select_product_process">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
                <div class="btns">
                    <button type="submit" form="select_product_process" onClick="return confirm('こちらの商品を選択します。\n後から変更はできませんが、よろしいですか？');">この商品を選ぶ</button>
                </div>
            </div>
        </div>
        <div>
            <p id="product_description">{{ $product->description }}</p>
        </div>
    </section>
@endsection

@include('layouts.footer')