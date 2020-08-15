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
                    <input type="password" id="current" name="current-password" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="password">新しいパスワード</label>
                    <input type="password" id="password" name="new-password" required>
                </li>
                <li class="input_parts">
                    <label for="confirm">新しいパスワード(確認用)</label>
                    <input type="password" id="confirm" name="new-password_confirmation" required autofocus>
                </li>
                <div class="btns">
                    <button type="submit">変更する</button>
                </div>
            </ul>
        </form>
    </section>
@endsection

@include('layouts.footer')