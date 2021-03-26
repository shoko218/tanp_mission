@extends('layouts.base')

@section('pagename')
    パスワード認証
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section class="normal_section" id="pass_verify">
    <h1>パスワードを認証してください</h1>
    <form method="POST" action="{{ route('password.confirm') }}" class="input_form">
        @csrf
        <ul class="inputs">
            <li class="input_parts">
                <label for="password">パスワード</label>
                <input  id="password" type="password" @if ($errors->has('password')) class="input_alert" @endif name="password" required autocomplete="current_password">
                @foreach ($errors->get('password') as $item)
                    <p class="form_alert">{{ $item }}</p>
                @endforeach
            </li>
        </ul>
        <div class="btns">
            <button type="submit">ログイン</button>
        </div>
    </form>
    <p><a href="{{ route('password.request') }}">パスワードをお忘れですか？</a></p>
</section>
@endsection

@include('layouts.footer')
