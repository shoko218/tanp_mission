@php
    $currentDate = date('Y/m/d');
    $birthday = $lover->birthday;
    $c = (int)date('Ymd', strtotime($currentDate));
    $b = (int)date('Ymd', strtotime($birthday));
    $age = (int)(($c - $b) / 10000);
@endphp
@extends('layouts.base')

@section('pagename')
    注文情報を登録する
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="fillin_info">
    <h1>お届け先の情報</h1>
    <p><span class="form_requires">*</span>は必須項目です</p>
        <form method="POST" action="/purchase/register_to_session" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="last_name">姓<span class="form_requires">*</span></label>
                    <input id="last_name" type="text" name="last_name" value="{{ $lover->last_name }}" placeholder="山田" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name">名<span class="form_requires">*</span></label>
                    <input id="first_name" type="text" name="first_name" value="{{ $lover->first_name }}" placeholder="太郎" required>
                <li class="input_parts">
                    <label for="last_name_furigana">セイ<span class="form_requires">*</span></label>
                    <input id="last_name_furigana" type="text" name="last_name_furigana" value="{{ $lover->last_name_furigana }}" placeholder="ヤマダ" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name_furigana">メイ<span class="form_requires">*</span></label>
                    <input id="first_name_furigana" type="text" name="first_name_furigana" value="{{ $lover->first_name_furigana }}" placeholder="タロウ" required>
                </li>
                <li class="input_parts">
                    <label for="postal_code">郵便番号(ハイフン抜き)<span class="form_requires">*</span></label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ $lover->postal_code }}" placeholder="xxxxxxx">
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県<span class="form_requires">*</span></label>
                    <select name="prefecture_id" id="prefecture_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if($lover->prefecture_id==$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下)<span class="form_requires">*</span></label>
                    <input id="address" type="text" name="address" value="{{ $lover->address }}" placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室">
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)<span class="form_requires">*</span></label>
                    <input id="telephone" type="text" name="telephone" value="{{ $lover->telephone }}" placeholder="xxxxxxxxxx">
                </li>
                <li class="input_parts">
                    <label for="scene_id">シーン</label>
                    <select id="scene_id" name="scene_id" value="{{ old('scene_id') }}" required>
                        <option disabled selected value>選択してください</option>
                        @foreach ($scenes as $scene)
                        <option value="{{ $scene->id }}">{{ $scene->name }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
            <input type="hidden" name="gender" value="{{ $lover->gender }}">
            <input type="hidden" name="relationship_id" value="{{ $lover->relationship_id }}">
            <input type="hidden" name="age" value="<?php echo $age?> ">
            <input type="hidden" name="lover_id" value="{{ $lover->id }}">
            <div class="btns">
                <button type="submit">次へ進む</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')