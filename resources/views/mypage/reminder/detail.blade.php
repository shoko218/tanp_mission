@extends('layouts.base')

@section('pagename')
    {{ $event->lover->last_name.$event->lover->first_name }}さん-{{ $event->title }}
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="reminder_detail">
        @include('components.msgs')
        <div id="reminder_detail_top">
            @if (env('APP_ENV') == 'production')
                <img src="{{ Storage::disk('s3')->url('event_imgs/'.sprintf('%05d', $event->scene_id)).'.jpg'}}" alt="" id="reminder_detail_img">
            @else
                <img src="/image/event_imgs/{{ sprintf('%05d', $event->scene_id)}}.jpg" alt="" id="reminder_detail_img">
            @endif
            <div id="reminder_detail_explanation">
                <h1 id="reminder_detail_explanation_title">{{ $event->title }}まで<br><span>あと{{ $diff->days }}日</span></h1>
                <p class="name"><i class="fas fa-user"></i>{{ $event->lover->last_name.$event->lover->first_name }}さん</p>
                <div class="btns">
                    <button onclick="location.href='{{ $url }}'">プレゼントを探しに行く→</button>
                </div>
                <p class="submit_a"><a href="/mypage/reminder/{{ $event->id }}/edit">このイベントを編集する</a></p>
                <form method="post" name="delete_form" id="delete_form" action="/mypage/reminder/delete_process">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                </form>
                <p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm('このイベントを削除します。\nよろしいですか？');">このイベントを削除する</a></p>
            </div>
        </div>
    </section>
@endsection

@include('layouts.footer')