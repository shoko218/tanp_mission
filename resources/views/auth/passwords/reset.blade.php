@extends('layouts.base')

@section('pagename')
    パスワードをリセット
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="pass_reset" class="normal_section">
    <h1>パスワードをリセット</h1>
    <form method="POST" action="{{ route('password.update') }}" class="input_form">
        @csrf
        <ul class="inputs">
            <li class="input_parts">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" readonly required>
            </li>
            <li class="input_parts">
                <label for="password">パスワード(8文字以上の英数字、記号)</label>
                <input id="password" type="password" name="password" required @if ($errors->has('password')) class="input_alert" @endif>
                @foreach ($errors->get('password') as $item)
                    <p class="form_alert">{{ $item }}</p>
                @endforeach
            </li>
            <li class="input_parts">
                <label for="password-confirm">パスワード(確認用)</label>
                <input id="password-confirm" type="password" name="password_confirmation" required @if ($errors->has('password_confirmation')) class="input_alert" @endif>
            </li>
        </ul>
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="btns">
            <button type="submit" onClick="return confirm('パスワードをリセットします。\nよろしいですか？');">リセット</button>
        </div>
    </form>
</section>
@endsection

@include('layouts.footer')

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" readonly>{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
