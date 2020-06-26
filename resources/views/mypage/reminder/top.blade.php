@extends('layouts.base')

@section('pagename')
    イベントリマインダー
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="reminder">
        <h1>イベントリマインダー</h1>
        <div id="events">
            @include('components.event_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.event_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.event_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.event_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.event_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
        </div>
        <div class="btns">
            <button onclick="location.href='/mypage/reminder/register'">新しいイベントを登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')
