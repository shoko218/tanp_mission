@extends('layouts.base')

@section('pagename')
    パスワードリセット
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="pass_reset_mail" class="normal_section">
        <h1>パスワードリセットメールを送信する</h1>
        <form method="POST" action="{{ route('password.email') }}" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required @if ($errors->has('email')) class="input_alert" @endif>
                    @foreach ($errors->get('email') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
            </ul>
            <div class="btns">
                <button type="submit" onClick="return confirm('パスワードをリセットするためのメールを送信します。\nよろしいですか？');">パスワードリセットメールを送信する</button>
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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
