@extends('layouts.base')

@section('pagename')
    新規登録
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="register">
        <h1>新規登録</h1>
        <p><span class="form_requires">*</span>は必須項目です</p>
        <form method="POST" action="{{ route('register') }}" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="last_name">姓<span class="form_requires">*</span></label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" @if ($errors->has('last_name')) class="input_alert" @endif placeholder="山田" required >
                    @foreach ($errors->get('last_name') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="first_name">名<span class="form_requires">*</span></label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" @if ($errors->has('first_name')) class="input_alert" @endif placeholder="太郎" required>
                    @foreach ($errors->get('first_name') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                <li class="input_parts">
                    <label for="last_name_furigana">セイ<span class="form_requires">*</span></label>
                    <input id="last_name_furigana" type="text" name="last_name_furigana" value="{{ old('last_name_furigana') }}" @if ($errors->has('last_name_furigana')) class="input_alert" @endif placeholder="ヤマダ" required >
                    @foreach ($errors->get('last_name_furigana') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="first_name_furigana">メイ<span class="form_requires">*</span></label>
                    <input id="first_name_furigana" type="text" name="first_name_furigana" value="{{ old('first_name_furigana') }}" @if ($errors->has('first_name_furigana')) class="input_alert" @endif placeholder="タロウ" required>
                    @foreach ($errors->get('first_name_furigana') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="email">メールアドレス<span class="form_requires">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" @if ($errors->has('email')) class="input_alert" @endif required autocomplete="email">
                    @foreach ($errors->get('email') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="password">パスワード(8文字以上の英数字)<span class="form_requires">*</span></label>
                    <input id="password" type="password" name="password" placeholder="password" @if ($errors->has('password')) class="input_alert" @endif required>
                    @foreach ($errors->get('password') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="password-confirm">確認用パスワード<span class="form_requires">*</span></label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="password" required>
                </li>
                <li class="input_parts">
                    <label for="birthday">誕生日<span class="form_requires">*</span></label>
                    <input id="birthday" type="date" name="birthday" value="{{ old('birthday') }}" required @if ($errors->has('birthday')) class="input_alert" @endif placeholder="1987-01-01">
                    @foreach ($errors->get('birthday') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">性別<span class="form_requires">*</span></p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked"@endif required>男性</label>
                        <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked"@endif>女性</label>
                        <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked"@endif>その他</label>
                    </div>
                    @foreach ($errors->get('gender') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="postal_code">郵便番号(ハイフン抜き)</label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" @if ($errors->has('postal_code')) class="input_alert" @endif placeholder="xxxxxxx">
                    @foreach ($errors->get('postal_code') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id" @if ($errors->has('prefecture_id')) class="input_alert" @endif>
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if(old('prefecture_id')==$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                    @foreach ($errors->get('prefecture_id') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下、全角英数字不可)</label>
                    <textarea id="address" type="text" name="address" value="{{ old('address') }}" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" rows="2" @if ($errors->has('address')) class="input_alert" @endif>{{ old('address') }}</textarea>
                    @foreach ($errors->get('address') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)</label>
                    <input id="telephone" type="text" name="telephone" value="{{ old('telephone') }}" placeholder="xxxxxxxxxx" @if ($errors->has('telephone')) class="input_alert" @endif>
                    @foreach ($errors->get('telephone') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
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