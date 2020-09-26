@extends('layouts.base')

@section('pagename')
    イベントリマインダー
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="event_reminder" class="normal_section">
        @include('components.msgs')
        <h1>イベントリマインダー</h1>
        @if(count($events)>0)
            <div id="events">
                @foreach ($events as $event)
                @include('components.event_card',['date'=>$event->date,'name'=>$event->lover->last_name.$event->lover->first_name,'title'=>$event->title,'id'=>$event->id,'order'=>$loop->index,'ext'=>$event->lover->img_extension,'lover_id'=>$event->lover->id])
                @endforeach
            </div>
            {{$events->appends(request()->input())->links()}}
        @else
            <h2>まだイベントはありません。</h2>
        @endif
        <div class="btns">
            <button onclick="location.href='/mypage/reminder/register'">新しいイベントを登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')
