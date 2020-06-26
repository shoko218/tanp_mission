@extends('layouts.base')

@section('pagename')
    大切な人-{{ $name }}さん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lover">
        <img src="{{ asset( 'image/lover_icons/noimage.png',true)}}" alt="{{ $name }}さん" id="lover_img">
        <p id="lover_name">{{ $name }}さん</p>
        <button onclick="location.href='/mypage/reminder/register'">イベント登録+</button>
        <button onclick="location.href='/mypage/lovers/gift_history'">今まであげたもの</button>
    </section>
@endsection

@include('layouts.footer')