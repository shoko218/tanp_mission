@extends('layouts.base')

@section('pagename')
    オリジナルカタログトップ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="original_catalog" class="normal_section">
    @include('components.msgs')
    <h1>オリジナルカタログ</h1>
    <div class="btns">
        <button onclick="location.href='register'">新しくカタログを作る</button>
    </div>
    <h2>今までに作ったオリジナルカタログ</h2>
    @if (count($results))
        <div class="rc_cards">
        @foreach ($results as $result)
            @include('components.original_catalog_card',['catalog_id'=>$result->id,'img_id'=>$result->img_num,'name'=>$result->name])
        @endforeach
        </div>
        {{$results->appends(request()->input())->links()}}
    @else
        <h3>まだカタログはありません。</h3>
    @endif
</section>
@endsection

@include('layouts.footer')