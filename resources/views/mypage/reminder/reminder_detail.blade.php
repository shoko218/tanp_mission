@extends('layouts.base')

@section('pagename')
    {{ $event->lover->last_name.$event->lover->first_name }}さん-{{ $event->title }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="reminder_detail">
        <img src="{{ asset( 'image/events/chiristmas.png',true)}}" alt="" id="reminder_detail_img">
        <div id="reminder_detail_explanation">
            <h1 id="reminder_detail_explanation_title">{{ $event->title }}まで<br><span>あと156日</span></h1>
            <p><i class="fas fa-user"></i>{{ $event->lover->last_name.$event->lover->first_name }}さん</p>
            <div class="btns">
                <button onclick="location.href='/result'">プレゼントを探しに行く→</button>
            </div>
        </div>
    </section>
@endsection

@include('layouts.footer')