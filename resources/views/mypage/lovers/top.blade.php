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
            @include('components.lover_card',['name'=>'にしむらりな','relationship'=>'恋人'])
            @include('components.lover_card',['name'=>'にしむらりな','relationship'=>'恋人'])
            @include('components.lover_card',['name'=>'にしむらりな','relationship'=>'恋人'])
            @include('components.lover_card',['name'=>'にしむらりな','relationship'=>'恋人'])
            @include('components.lover_card',['name'=>'にしむらりな','relationship'=>'恋人'])
        </div>
        <div class="btns">
            <button>新しい大切な人を登録→</button>
        </div>
    </section>
@endsection

@include('layouts.footer')