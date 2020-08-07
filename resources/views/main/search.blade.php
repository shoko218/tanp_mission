@extends('layouts.base')

@section('pagename')
検索
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="conditions">
    <h1>検索</h1>
    @include('components.search_form')
</section>
@endsection

@include('layouts.footer')