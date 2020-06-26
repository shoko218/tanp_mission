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
            @foreach ($events as $event)
            @include('components.event_card',['date'=>$event->date,'name'=>$event->lover->last_name.$event->lover->first_name,'scene'=>$event->scene->name,'title'=>$event->title,'id'=>$event->id,'order'=>$loop->index])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/mypage/reminder/register'">新しいイベントを登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')
