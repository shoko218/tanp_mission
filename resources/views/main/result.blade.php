@extends('layouts.base')

@section('pagename')
検索結果
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="conditions">
    <h1>検索結果</h1>
    @include('components.search_form')
</section>
@if (count($results))
<section id="results">
    <div class="rc_cards">
    @foreach ($results as $result)
        @include('components.product_card',['product_id'=>$result->id,'title'=>$result->name,'genre'=>$result->genre->name,'price'=>$result->price])
    @endforeach
    </div>
    {{$results->appends(request()->input())->links()}}
</section>
@else
<section id="result_notfound" class="normal_section">
    <h2>商品が見つかりませんでした。<br>他の検索条件をお試しください。</h2>
</section>
@endif

@endsection

@include('layouts.footer')