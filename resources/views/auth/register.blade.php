@extends('layouts.base')

@section('pagename')
    新規登録
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="register">
        @if ($errors->any())
            @include('components.errmsg')
        @endif
        <h1>新規登録</h1>
        <p><span class="form_requires">*</span>は必須項目です</p>
        <form method="POST" action="{{ route('register') }}" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="last_name">姓<span class="form_requires">*</span></label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="山田" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name">名<span class="form_requires">*</span></label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="太郎" required>
                <li class="input_parts">
                    <label for="last_name_furigana">セイ<span class="form_requires">*</span></label>
                    <input id="last_name_furigana" type="text" name="last_name_furigana" value="{{ old('last_name_furigana') }}" placeholder="ヤマダ" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name_furigana">メイ<span class="form_requires">*</span></label>
                    <input id="first_name_furigana" type="text" name="first_name_furigana" value="{{ old('first_name_furigana') }}" placeholder="タロウ" required>
                </li>
                <li class="input_parts">
                    <label for="email">メールアドレス<span class="form_requires">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" required autocomplete="email">
                </li>
                <li class="input_parts">
                    <label for="password">パスワード<span class="form_requires">*</span></label>
                    <input id="password" type="password" name="password" placeholder="password" required>
                </li>
                <li class="input_parts">
                    <label for="password-confirm">確認用パスワード<span class="form_requires">*</span></label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="password" required>
                </li>
                <li class="input_parts">
                    <label for="birthday">誕生日<span class="form_requires">*</span></label>
                    <input id="birthday" type="date" name="birthday" value="{{ old('birthday') }}" required>
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">性別<span class="form_requires">*</span></p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked"@endif>男性</label>
                        <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked"@endif>女性</label>
                        <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked"@endif>その他</label>
                    </div>
                </li>
                <li class="input_parts">
                    <label for="postal_code">郵便番号(ハイフン抜き)</label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="xxxxxxx">
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if(old('prefecture_id')==$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下)</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室">
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)</label>
                    <input id="telephone" type="text" name="telephone" value="{{ old('telephone') }}" placeholder="xxxxxxxxxx">
                </li>
                <li>
                    <label class="check">
                        <input type="checkbox" name="agree" class="checkbtn" {{ is_array(old("agree")) && in_array("1", old("agree"), true)? 'checked="checked"' : ''}} required>
                        <a href="rules" target="_blank">利用規約</a>に同意します。
                    </label>
                </li>
            </ul>
            <div class="btns">
                <button type="submit">登録</button>
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
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    {{ __('Register') }}
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
