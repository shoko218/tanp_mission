@extends('layouts.base')

@section('pagename')
    登録内容変更
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="register">
        @include('components.msgs')
        <h1>登録内容を変更する</h1>
        <p><span class="form_requires">*</span>は必須項目です</p>
        <form method="POST" action="edit_process" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="last_name">姓<span class="form_requires">*</span></label>
                    <input id="last_name" type="text" name="last_name" @if(old('last_name')!=null) value="{{ old('last_name') }}" @elseif(Auth::user()->last_name!=null) value="{{ Auth::user()->last_name }}" @endif placeholder="山田" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name">名<span class="form_requires">*</span></label>
                    <input id="first_name" type="text" name="first_name" @if(old('first_name')!=null) value="{{ old('first_name') }}" @elseif(Auth::user()->first_name!=null) value="{{ Auth::user()->first_name }}" @endif placeholder="太郎" required>
                <li class="input_parts">
                    <label for="last_name_furigana">セイ<span class="form_requires">*</span></label>
                    <input id="last_name_furigana" type="text" name="last_name_furigana" @if(old('last_name_furigana')!=null) value="{{ old('last_name_furigana') }}" @elseif(Auth::user()->last_name_furigana!=null) value="{{ Auth::user()->last_name_furigana }}" @endif placeholder="ヤマダ" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name_furigana">メイ<span class="form_requires">*</span></label>
                    <input id="first_name_furigana" type="text" name="first_name_furigana" @if(old('first_name_furigana')!=null) value="{{ old('first_name_furigana') }}" @elseif(Auth::user()->first_name_furigana!=null) value="{{ Auth::user()->first_name_furigana }}" @endif placeholder="タロウ" required>
                </li>
                <li class="input_parts">
                    <p class="go_other_page"><a href="edit_email">メールアドレスの変更はこちらから</a></p>
                </li>
                <li class="input_parts">
                    <p class="go_other_page"><a href="edit_pass">パスワードの変更はこちらから</a></p>
                </li>
                <li class="input_parts">
                    <label for="birthday">誕生日<span class="form_requires">*</span></label>
                    <input id="birthday" type="date" name="birthday" @if(old('birthday')!=null) value="{{ old('birthday') }}" @elseif(Auth::user()->birthday!=null) value="{{ Auth::user()->birthday->format('Y-m-d') }}" @endif required>
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">性別<span class="form_requires">*</span></p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked" @elseif(Auth::user()->gender===0) checked="checked" @endif required>男性</label>
                        <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked" @elseif(Auth::user()->gender===1) checked="checked" @endif>女性</label>
                        <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked" @elseif(Auth::user()->gender===2) checked="checked" @endif>その他</label>
                    </div>
                </li>
                <li class="input_parts">
                    <label for="postal_code">郵便番号(ハイフン抜き)</label>
                    <input id="postal_code" type="text" name="postal_code" @if(old('postal_code')!=null) value="{{ old('postal_code') }}" @elseif(Auth::user()->postal_code!=null) value="{{ Auth::user()->postal_code }}" @endif placeholder="xxxxxxx">
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if(old('prefecture_id')==$pref->id) selected  @elseif(Auth::user()->prefecture_id===$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下)</label>
                    <textarea id="address" type="text" name="address" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" rows="2">@if(old('address')!=null){{old('address')}}@elseif(Auth::user()->address!=null){{Auth::user()->address}}@endif</textarea>
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)</label>
                    <input id="telephone" type="text" name="telephone" @if(old('telephone')!=null) value="{{ old('telephone') }}" @elseif(Auth::user()->telephone!=null) value="{{ Auth::user()->telephone }}" @endif placeholder="xxxxxxxxxx">
                </li>
            </ul>
            <div class="btns">
                <button type="submit">変更する</button>
            </div>
        </form>
    </section>
@endsection
@include('layouts.footer')
