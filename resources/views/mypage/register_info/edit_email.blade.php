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
                    <label for="email">新しいメールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" required autocomplete="email" @if ($errors->has('email')) class="input_alert" @endif>
                    @foreach ($errors->get('email') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </div>
            </div>
            <div class="btns">
                <button type="submit">送信</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')