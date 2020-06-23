@extends('layouts.base')

@section('pagename')
    大切な人リスト
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="reminder">
        <h1>大切な人リスト</h1>
        <div id="lovers">
            @foreach ($lovers as $lover)
            @include('components.lover_card',['name'=>$lover->last_name.$lover->first_name,'relationship'=>$lover->name])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/mypage/lovers/register'">新しい大切な人を登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')