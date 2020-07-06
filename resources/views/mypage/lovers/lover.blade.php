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
        <div class="lovers_btns">
            <button onclick="location.href='/mypage/reminder/register'">イベント登録+</button>
            <form action="/mypage/lovers/gift_history" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="name" value="{{ $name }}">
                <button type="submit">今まであげたもの</button>
            </form>
        </div>
    </section>
@endsection

@include('layouts.footer')