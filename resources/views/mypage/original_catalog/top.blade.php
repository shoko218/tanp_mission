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
        <button onclick="location.href='/mypage/original_catalog/register'">新しくカタログを作る</button>
    </div>
    <h2>今までに作ったオリジナルカタログ</h2>
    <original-catalog-component :csrf="{{json_encode(csrf_token())}}" @if(env('APP_ENV') == 'production') s3-directory={{ Storage::disk('s3')->url('catalog_imgs/')}} @endif></original-catalog-component>
</section>
@endsection

@include('layouts.footer')