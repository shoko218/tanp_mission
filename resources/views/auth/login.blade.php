@extends('layouts.base')

@section('pagename')
    ログイン
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="login">
    @include('components.msgs')
    <h1>ログインしてください</h1>
    <form method="POST" action="{{ route('login') }}" class="input_form">
        @csrf
        <ul class="inputs">
            <li class="input_parts">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </li>
            <li class="input_parts">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" autocomplete="current-password">
            </li>
            <li>
                <label class="check" for="check"><input type="checkbox" value="check" class="checkbtn" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>ログイン情報を記憶する</label>
            </li>
        </ul>
        <div class="btns">
            <button type="submit">ログイン</button>
        </div>
    </form>
    <ul class="login_nav">
        <li>
            <a href="{{ route('password.request') }}">パスワードをお忘れですか?</a>
        </li>
        <li>
            <a href="/register">ご登録がまだの方はこちらから</a>
        </li>
    </ul>
</section>
@endsection

@include('layouts.footer')