@extends('layouts.base')

@section('pagename')
    パスワード変更
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section class="normal_section" id="update_pass">
        @include('components.msgs')
        <h1>パスワードを変更する</h1>
        <form action="edit_pass_process" method="POST">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="current">現在のパスワード</label>
                    <input type="password" id="current" name="current_password" required >
                </li>
                <li class="input_parts">
                    <label for="password">新しいパスワード(8文字以上の英数字)</label>
                    <input type="password" id="password" name="new_password" required @if ($errors->has('new_password')) class="input_alert" @endif>
                    @foreach ($errors->get('new_password') as $error)
                        <p class="form_alert">{{ $error }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="confirm">新しいパスワード(確認用)</label>
                    <input type="password" id="confirm" name="new_password_confirmation" required >
                </li>
                <div class="btns">
                    <button type="submit">変更する</button>
                </div>
            </ul>
        </form>
    </section>
@endsection

@include('layouts.footer')
