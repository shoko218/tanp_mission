@extends('layouts.base')

@section('pagename')
メールアドレスを認証してください
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section class="normal_section" id="please_verify_email">
    <h1>メールアドレスの認証が必要です</h1>
    <p>登録されたメールアドレスあてに認証メールを送信致しました。メールの中のボタンをクリックし、認証を完了させてください。もしもメールが届いていない場合は下のボタンをクリックしてください。</p>
    <form method="POST" action="{{ route('verification.resend') }}" id="verify">
        @csrf
    </form>
    <div class="btns">
        <button type="submit" form="verify">再度メールを送信する</button>.
    </div>
</section>
@endsection

@include('layouts.footer')