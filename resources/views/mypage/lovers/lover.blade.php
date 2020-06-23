@extends('layouts.base')

@section('pagename')
    にしむらりなさん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lover">
        <img src="{{ asset( 'image/lover_icons/noimage.png',true)}}" alt="にしむらりなさん" id="lover_img">
        <p id="lover_name">にしむらりな さん</p>
        <button onclick="location.href='/mypage/reminder/register'">記念日登録+</button>
        <button onclick="location.href='/mypage/lovers/gift_history'">今まであげたもの</button>
    </section>
@endsection

@include('layouts.footer')