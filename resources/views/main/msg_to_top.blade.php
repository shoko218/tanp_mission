@extends('layouts.base')

@section('pagename')
   {{ $title }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section class="normal_section">
        <h1>{{ $msg }}</h1>
        <div class="btns">
            <button onclick="location.href='/'">トップへ戻る</button>
        </div>
    </section>
@endsection

@include('layouts.footer')