@extends('layouts.base')

@section('pagename')
    大切な人リスト
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lovers_list" class="normal_section">
        @include('components.msgs')
        <h1>大切な人リスト</h1>
        @if (count($lovers)===0)
            <h2>まだ大切な人は登録されていません。</h2>
        @endif
        <div id="lovers">
            @foreach ($lovers as $lover)
            @include('components.lover_card',['name'=>$lover->last_name.$lover->first_name,'relationship'=>$lover->name,'order'=>$loop->index,'id'=>$lover->id,'ext'=>$lover->img_extension])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/mypage/lovers/register'">新しい大切な人を登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')