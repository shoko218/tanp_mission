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
    <original-catalog-component :csrf="{{json_encode(csrf_token())}}"></original-catalog-component>
</section>
@endsection

@include('layouts.footer')