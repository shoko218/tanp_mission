@extends('layouts.base')

@section('pagename')
    にしむらりなさん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lover">
        <img src="{{ asset( 'image/lover_icons/test.png',true)}}" alt="にしむらりなさん" id="lover_img">
        <p id="lover_name">にしむらりな さん</p>
        <button>記念日追加+</button>
        <button>今まであげたもの</button>
    </section>
@endsection

@include('layouts.footer')