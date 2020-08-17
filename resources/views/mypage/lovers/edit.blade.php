@extends('layouts.base')

@section('pagename')
    大切な人の登録情報を確認・編集
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lovers_register" class="normal_section">
        @include('components.msgs')
        <h1>{{ $lover->last_name.$lover->first_name }}さんの登録情報を確認・編集</h1>
        <p><span class="form_requires">*</span>は必須項目です</p>
        <form action="/mypage/lovers/edit_process" method="POST" enctype='multipart/form-data' class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="last_name">姓<span class="form_requires">*</span></label>
                    <input id="last_name" type="text" name="last_name" @if(old('last_name')!=null) value="{{ old('last_name') }}" @elseif($lover->last_name!=null) value="{{$lover->last_name}}" @endif placeholder="山田" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name">名<span class="form_requires">*</span></label>
                    <input id="first_name" type="text" name="first_name" @if(old('first_name')!=null) value="{{ old('first_name') }}" @elseif($lover->first_name!=null) value="{{ $lover->first_name }}" @endif placeholder="太郎" required>
                <li class="input_parts">
                    <label for="last_name_furigana">セイ<span class="form_requires">*</span></label>
                    <input id="last_name_furigana" type="text" name="last_name_furigana" @if(old('last_name_furigana')!=null) value="{{ old('last_name_furigana') }}" @elseif($lover->last_name_furigana!=null) value="{{ $lover->last_name_furigana }}" @endif placeholder="ヤマダ" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="first_name_furigana">メイ<span class="form_requires">*</span></label>
                    <input id="first_name_furigana" type="text" name="first_name_furigana" @if(old('first_name_furigana')!=null) value="{{ old('first_name_furigana') }}" @elseif($lover->first_name_furigana!=null) value="{{ $lover->first_name_furigana }}" @endif placeholder="タロウ" required>
                </li>
                <li class="input_parts">
                    <label for="birthday">誕生日<span class="form_requires">*</span></label>
                    <input id="birthday" type="date" name="birthday" @if(old('birthday')!=null) value="{{ old('birthday') }}" @elseif($lover->birthday!=null) value="{{ $lover->birthday }}" @endif required>
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">性別<span class="form_requires">*</span></p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked" @elseif($lover->gender===0) checked="checked" @endif>男性</label>
                        <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked" @elseif($lover->gender===1) checked="checked" @endif>女性</label>
                        <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked" @elseif($lover->gender===2) checked="checked" @endif>その他</label>
                    </div>
                </li>
                <li class="input_parts">
                    <label for="relationship_id">どのようなご関係ですか？<span class="form_requires">*</span></label>
                    <select name="relationship_id" id="relationship_id">
                        <option value="" selected disabled>選択してください</option>
                        @foreach ($relationships as $rel)
                            <option value="{{ $rel->id }}"@if(old('relationship_id')===$rel->id) selected @elseif($lover->relationship_id===$rel->id) selected @endif>{{ $rel->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="postal_code">郵便番号(ハイフン抜き)</label>
                    <input id="postal_code" type="text" name="postal_code" @if(old('')!=null) value="{{ old('postal_code') }}" @elseif($lover->postal_code!=null) value="{{ $lover->postal_code }}" @endif placeholder="xxxxxxx">
                </li>
                <li class="input_parts">
                    <label for="prefecture_id">都道府県</label>
                    <select name="prefecture_id" id="prefecture_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($prefectures as $pref)
                            <option value="{{ $pref->id }}"@if(old('prefecture_id')===$pref->id) selected @elseif($lover->prefecture_id===$pref->id) selected @endif>{{ $pref->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="address">住所(市町村以下)</label>
                    <input id="address" type="text" name="address" @if(old('address')!=null) value="{{ old('address') }}" @elseif($lover->address!=null) value="{{ $lover->address }}" @endif placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室">
                </li>
                <li class="input_parts">
                    <label for="telephone">電話番号(ハイフン抜き)</label>
                    <input id="telephone" type="text" name="telephone" @if(old('telephone')!=null) value="{{ old('telephone') }}" @elseif($lover->telephone!=null) value="{{ $lover->telephone }}" @endif placeholder="xxxxxxxxxx">
                </li>
                {{-- <li>
                    <label for="relationship_id">写真</label>
                    <input type="file" name="example" accept="image/jpeg, image/png">
                </li> --}}
            </ul>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="lover_id" value="{{ $lover->id }}">
            <div class="btns">
                <button>変更する</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')