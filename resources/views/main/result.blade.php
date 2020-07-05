@extends('layouts.base')

@section('pagename')
検索結果
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="conditions">
    <h1>検索結果</h1>
    <form action="/result" class="search_form" method="post">
        @csrf
        <input type="text" class="search_bar" value="{{ $keyword }}" name="keyword" placeholder="検索したいワードを入力">
        <div class="btns">
            <button type="submit" class="search_btn">検索</button>
        </div>
    </form>
</section>
<section id="results">
    <div class="rc_cards">
        @if ($results)
        @foreach ($results as $result)
            @include('components.product_card',['product_id'=>$result->id,'title'=>$result->product_name,'genre'=>$result->genre,'price'=>$result->price])
        @endforeach
        @endif
    </div>
    {{ $results->links() }}
</section>
@endsection

@include('layouts.footer')