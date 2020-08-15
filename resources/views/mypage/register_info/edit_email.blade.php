@extends('layouts.base')

@section('pagename')
    メールアドレス変更
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section class="normal_section" id="update_email">
        @include('components.msgs')
        <h1>メールアドレスを変更する</h1>
        <form action="send_mail_to_edit_email_process" method="POST" class="input_form">
            @csrf
            <div class="inputs">
                <div class="input_parts">
                    <label for="last_name">新しいメールアドレス</label>
                    <input id="new_email" type="email" name="new_email" value="{{ session('new_email') }}">
                </div>
            </div>
            <div class="btns">
                <button type="submit">送信</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')