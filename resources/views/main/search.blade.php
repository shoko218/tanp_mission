@extends('layouts.base')

@section('pagename')
    検索結果
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="conditions">
    <h1>「{{ $word }}」の検索結果</h1>
    <form action="/search" class="search_form">
        @csrf
        <input type="text" class="search_bar" value="{{ $word }}" name="word">
        <div class="btns">
            <button type="submit">検索</button>
        </div>
    </form>
</section>
<section id="results">
    <div class="rc_cards">
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
        @include('components.rank_card',['product_id'=>'test','title'=>'ぱんだのぬいぐるみ','genre'=>'ぬいぐるみ','price'=>'4,500'])
    </div>
</section>
@endsection

@include('layouts.footer')