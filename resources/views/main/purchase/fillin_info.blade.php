@extends('layouts.base')

@section('pagename')
    注文情報を登録する
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="fillin_info" class="normal_section">
    <h1>お届け先の情報</h1>
    <p><span class="form_requires">*</span>は必須項目です</p>
    @if (Auth::check())
    <form method="POST" action="/purchase/fillin_lover_info" class="input_form">
        @csrf
        <li class="input_parts">
            <label for="lover_id">大切な人リストに登録した方ですか？<span class="form_requires">*</span></label>
            <select id="lover_id" name="lover_id" onchange="submit(this.form)" required>
                <option selected value="">いいえ</option>
                @foreach ($lovers as $lover)
                <option value="{{ $lover->id }}">{{ $lover->last_name.$lover->first_name }}</option>
                @endforeach
            </select>
        </li>
    </form>
    @endif
        <form method="POST" action="/purchase/register_to_session" class="input_form">
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
                    <label for="postal_code">郵便番号(ハイフン抜き)<span class="form_requires">*</span></label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="xxxxxxx" required>
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県<span class="form_requires">*</span></label>
                    <select name="prefecture_id" id="prefecture_id" required>
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if(old('prefecture_id')==$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下)<span class="form_requires">*</span></label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" required>
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)<span class="form_requires">*</span></label>
                    <input id="telephone" type="text" name="telephone" value="{{ old('telephone') }}" placeholder="xxxxxxxxxx" required>
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">性別</p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked"@endif>男性</label>
                        <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked"@endif>女性</label>
                        <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked"@endif>その他</label>
                    </div>
                </li>
                <li class="input_parts">
                    <label for="relationship_id">どのようなご関係ですか？</label>
                    <select name="relationship_id" id="relationship_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($relationships as $rel)
                            <option value="{{ $rel->id }}"@if(old('relationship_id')==$rel->id) selected @endif>{{ $rel->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="age">ご年齢</label>
                    <input id="age" type="text" name="age" value="{{ old('age') }}" placeholder="27">
                </li>
                <li class="input_parts">
                    <label for="scene_id">シーン</label>
                    <select id="scene_id" name="scene_id" value="{{ old('scene_id') }}">
                        <option disabled selected value>選択してください</option>
                        @foreach ($scenes as $scene)
                        <option value="{{ $scene->id }}">{{ $scene->name }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
            @if (Auth::check())
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endif
            <input type="hidden" name="lover_id" value="">
            <div class="btns">
                <button type="submit">次へ進む</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')