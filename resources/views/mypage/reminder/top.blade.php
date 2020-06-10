@extends('layouts.base')

@section('pagename')
    記念日リマインダー
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="reminder">
        <h1>記念日リマインダー</h1>
        <div id="anniversarys">
            @include('components.anniversary_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.anniversary_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.anniversary_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.anniversary_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
            @include('components.anniversary_card',['date'=>'8月26日','person'=>'にしむら','event'=>'お誕生日'])
        </div>
        <div class="btns">
            <button onclick="location.href='/mypage/reminder/anniversary_register'">新しい記念日を登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')
