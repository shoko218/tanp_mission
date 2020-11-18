@extends('layouts.base')

@section('pagename')
    カタログ選択
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="original_catalog_select" class="normal_section">
    @include('components.msgs')
    <h1>どのカタログに商品を追加しますか？</h1>
    @if (count($results))
        <div class="rc_cards">
        @foreach ($results as $result)
            @include('components.add_product_catalog_card',['catalog_id'=>$result->id,'img_id'=>$result->img_num,'name'=>$result->name])
        @endforeach
        </div>
        {{$results->appends(request()->input())->links()}}
    @else
        <h2>まだカタログはありません。</h2>
        <div class="btns">
            <button onclick="location.href='/mypage/original_catalog/register'">新しくカタログを作る</button>
        </div>
    @endif
</section>
@endsection

@include('layouts.footer')
