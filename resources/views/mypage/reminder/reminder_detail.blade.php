@extends('layouts.base')

@section('pagename')
    
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="reminder_detail">
        <img src="{{ asset( 'image/events/chiristmas.png',true)}}" alt="" id="reminder_detail_img">
        <div id="reminder_detail_explanation">
            <h1 id="reminder_detail_explanation_title">りなさんとの誕生日まで<br><span>あと156日</span></h1>
            <div class="btns">
                <button onclick="location.href='/result'">プレゼントを探しに行く→</button>
            </div>
        </div>
    </section>
@endsection

@include('layouts.footer')