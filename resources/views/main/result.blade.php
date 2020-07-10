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
<section id="results">
    <div class="rc_cards">
        @if ($results)
        @foreach ($results as $result)
            @include('components.product_card',['product_id'=>$result->id,'title'=>$result->name,'genre'=>$result->genre->name,'price'=>$result->price])
        @endforeach
        @endif
    </div>
    {{$results->appends(request()->input())->links()}}
</section>
@endsection

@include('layouts.footer')