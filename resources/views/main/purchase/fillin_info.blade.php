@php
    if($lover!=null){
        $currentDate = date('Y/m/d');
        $birthday = $lover->birthday;
        $c = (int)date('Ymd', strtotime($currentDate));
        $b = (int)date('Ymd', strtotime($birthday));
        $age = (int)(($c - $b) / 10000);
    }
@endphp
@extends('layouts.base')

@section('pagename')
    注文情報を登録する
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="fillin_info" class="normal_section">
        <h1>購入情報の入力</h1>
        <p><span class="form_requires">*</span>は必須項目です</p>
        @if (Auth::check())
        <form method="POST" action="/purchase/fillin_lover_info" class="input_form">
            @csrf
            <div class="input_parts">
                <label for="lover_id">大切な人リストに登録した方へのお届けですか？</label>
                <select id="lover_id" name="lover_id" onchange="submit(this.form)" >
                    <option selected value="">いいえ</option>
                    @foreach ($lovers as $item)
                    <option value="{{ $item->id }}" @if($lover!=null&&$lover->id==$item->id) selected @endif>{{ $item->last_name.$item->first_name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        @endif
        <form method="POST" action="/purchase/register_to_session" class="input_form" id="fillin_form">
            @csrf
            <div id="fillin_form_divs">
                <div class="fillin_form_div">
                    <h2>お届け先情報の入力</h2>
                    <ul class="inputs">
                        <li class="input_parts">
                            <label for="forwarding_last_name">姓<span class="form_requires">*</span></label>
                            <input id="forwarding_last_name" type="text" name="forwarding_last_name" @if(old('forwarding_last_name')!=null)value="{{ old('forwarding_last_name') }}"@elseif($lover!=null&&$lover->last_name!=null) value="{{ $lover->last_name }}" @endif @if ($errors->has('forwarding_last_name')) class="input_alert" @endif  placeholder="山田" required >
                            @foreach ($errors->get('forwarding_last_name') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_first_name">名<span class="form_requires">*</span></label>
                            <input id="forwarding_first_name" type="text" name="forwarding_first_name" @if(old('forwarding_first_name')!=null)value="{{ old('forwarding_first_name') }}"@elseif($lover!=null&&$lover->first_name!=null) value="{{ $lover->first_name }}" @endif @if ($errors->has('forwarding_first_name')) class="input_alert" @endif  placeholder="太郎" required>
                            @foreach ($errors->get('forwarding_first_name') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_last_name_furigana">セイ<span class="form_requires">*</span></label>
                            <input id="forwarding_last_name_furigana" type="text" name="forwarding_last_name_furigana" @if(old('forwarding_last_name_furigana')!=null)value="{{ old('forwarding_last_name_furigana') }}"@elseif($lover!=null&&$lover->last_name_furigana!=null) value="{{ $lover->last_name_furigana }}" @endif @if ($errors->has('forwarding_last_name_furigana')) class="input_alert" @endif  placeholder="ヤマダ" required>
                            @foreach ($errors->get('forwarding_last_name_furigana') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_first_name_furigana">メイ<span class="form_requires">*</span></label>
                            <input id="forwarding_first_name_furigana" type="text" name="forwarding_first_name_furigana" @if(old('forwarding_first_name_furigana')!=null)value="{{ old('forwarding_first_name_furigana') }}"@elseif($lover!=null&&$lover->first_name_furigana!=null) value="{{ $lover->first_name_furigana }}" @endif @if ($errors->has('forwarding_first_name_furigana')) class="input_alert" @endif  placeholder="タロウ" required>
                            @foreach ($errors->get('forwarding_first_name_furigana') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_postal_code">郵便番号(ハイフン抜き)<span class="form_requires">*</span></label>
                            <input id="forwarding_postal_code" type="text" name="forwarding_postal_code" @if(old('forwarding_postal_code')!=null) value="{{ old('forwarding_postal_code') }}" @elseif($lover!=null&&$lover->postal_code!=null) value="{{ $lover->postal_code }}" @endif @if ($errors->has('forwarding_postal_code')) class="input_alert" @endif  placeholder="xxxxxxx" required>
                            @foreach ($errors->get('forwarding_postal_code') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_prefecture_id">都道府県<span class="form_requires">*</span></label>
                            <select name="forwarding_prefecture_id" id="forwarding_prefecture_id" @if ($errors->has('forwarding_prefecture_id')) class="input_alert" @endif required>
                                <option value="" selected disabled>選択してください</option>
                                @foreach ($prefectures as $pref)
                                    <option value="{{ $pref->id }}" @if(old('forwarding_prefecture_id')==$pref->id) selected @elseif($lover!=null&&$lover->prefecture_id==$pref->id) selected @endif>{{ $pref->name }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('forwarding_prefecture_id') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_address">住所(市町村以下、全角英数字不可)<span class="form_requires">*</span></label>
                            <input id="forwarding_address" type="text" name="forwarding_address" @if(old('forwarding_address')!=null) value="{{ old('forwarding_address') }}" @elseif($lover!=null&&$lover->address!=null) value="{{ $lover->address }}" @endif @if ($errors->has('forwarding_address')) class="input_alert" @endif  placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" required>
                            @foreach ($errors->get('forwarding_address') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="forwarding_telephone">電話番号(ハイフン抜き)<span class="form_requires">*</span></label>
                            <input id="forwarding_telephone" type="text" name="forwarding_telephone" @if(old('forwarding_telephone')!=null) value="{{ old('forwarding_telephone') }}" @elseif($lover!=null&&$lover->telephone!=null) value="{{ $lover->telephone }}" @endif @if ($errors->has('forwarding_telephone')) class="input_alert" @endif  placeholder="xxxxxxxxxx" required>
                            @foreach ($errors->get('forwarding_telephone') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="scene_id">シーン</label>
                            <select id="scene_id" name="scene_id" value="{{ old('scene_id') }}" @if($errors->has('scene_id')) class="input_alert" @endif >
                                <option value="" selected>選択してください</option>
                                @foreach ($scenes as $scene)
                                <option value="{{ $scene->id }}">{{ $scene->name }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('scene_id') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="age">年齢</label>
                            <input id="age" type="text" name="age" @if(old('age')!=null) value="{{ old('age') }}" @elseif($lover!=null&&$age!=null) value="{{ $age }}" @endif @if ($errors->has('age')) class="input_alert" @endif  placeholder="24">
                            @foreach ($errors->get('age') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="radio_parts">
                            <p class="radiobtns_label">性別</p>
                            <div class="radiobtns">
                                <label class="radio"><input type="radio" name="gender" value="0" class="radiobtn" @if(old('gender')==='0')checked="checked" @elseif($lover!=null&&$lover->gender==0) checked="checked" @endif>男性</label>
                                <label class="radio"><input type="radio" name="gender" value="1" class="radiobtn" @if(old('gender')==='1')checked="checked" @elseif($lover!=null&&$lover->gender==1) checked="checked" @endif>女性</label>
                                <label class="radio"><input type="radio" name="gender" value="2" class="radiobtn" @if(old('gender')==='2')checked="checked" @elseif($lover!=null&&$lover->gender==2) checked="checked" @endif>その他</label>
                            </div>
                            @foreach ($errors->get('gender') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                        <li class="input_parts">
                            <label for="relationship_id">どのようなご関係ですか？</label>
                            <select name="relationship_id" id="relationship_id" @if ($errors->has('relationship_id')) class="input_alert" @endif >
                                <option value="" selected disabled>選択してください</option>
                                @foreach ($relationships as $rel)
                                    <option value="{{ $rel->id }}"@if(old('relationship_id')===$rel->id) selected @elseif($lover!=null&&$lover->relationship_id!=null&&$lover->relationship_id===$rel->id) selected @endif>{{ $rel->name }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('relationship_id') as $item)
                                <p class="form_alert">{{ $item }}</p>
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="fillin_form_div">
                    <h2>ご注文者様情報の入力</h2>
                    <ul class="inputs">
                            <li class="input_parts">
                                <label for="user_last_name">姓<span class="form_requires">*</span></label>
                                <input id="user_last_name" type="text" name="user_last_name" @if(old('user_last_name')!=null)value="{{ old('user_last_name') }}"@elseif(Auth::check()&&Auth::user()->last_name!=null)value="{{ Auth::user()->last_name }}"@endif @if ($errors->has('user_last_name')) class="input_alert" @endif placeholder="山田" required>
                                @foreach ($errors->get('user_last_name') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_first_name">名<span class="form_requires">*</span></label>
                                <input id="user_first_name" type="text" name="user_first_name" @if(old('user_first_name')!=null)value="{{ old('user_first_name') }}"@elseif(Auth::check()&&Auth::user()->first_name!=null)value="{{ Auth::user()->first_name }}"@endif @if ($errors->has('user_first_name')) class="input_alert" @endif placeholder="太郎" required>
                                @foreach ($errors->get('user_first_name') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_last_name_furigana">セイ<span class="form_requires">*</span></label>
                                <input id="user_last_name_furigana" type="text" name="user_last_name_furigana" @if(old('user_last_name_furigana')!=null)value="{{ old('user_last_name_furigana') }}"@elseif(Auth::check()&&Auth::user()->last_name_furigana!=null)value="{{ Auth::user()->last_name_furigana }}"@endif @if ($errors->has('user_last_name_furigana')) class="input_alert" @endif placeholder="ヤマダ" required>
                                @foreach ($errors->get('user_last_name_furigana') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_first_name_furigana">メイ<span class="form_requires">*</span></label>
                                <input id="user_first_name_furigana" type="text" name="user_first_name_furigana" @if(old('user_first_name_furigana')!=null)value="{{ old('user_first_name_furigana') }}"@elseif(Auth::check()&&Auth::user()->first_name_furigana!=null)value="{{ Auth::user()->first_name_furigana }}"@endif @if ($errors->has('user_first_name_furigana')) class="input_alert" @endif placeholder="タロウ" required>
                                @foreach ($errors->get('user_first_name_furigana') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_postal_code">郵便番号(ハイフン抜き)<span class="form_requires">*</span></label>
                                <input id="user_postal_code" type="text" name="user_postal_code" @if(old('user_postal_code')!=null)value="{{ old('user_postal_code') }}"@elseif(Auth::check()&&Auth::user()->postal_code!=null)value="{{ Auth::user()->postal_code }}"@endif @if ($errors->has('user_postal_code')) class="input_alert" @endif placeholder="xxxxxxx" required>
                                @foreach ($errors->get('user_postal_code') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_prefecture_id">都道府県<span class="form_requires">*</span></label>
                                <select name="user_prefecture_id" id="user_prefecture_id" @if ($errors->has('user_prefecture_id')) class="input_alert" @endif required>
                                    <option value="" selected disabled>選択してください</option>
                                    @foreach ($prefectures as $pref)
                                        <option value="{{ $pref->id }}"@if(old('user_prefecture_id')==$pref->id) selected @elseif(Auth::check()&&Auth::user()->prefecture_id===$pref->id) selected @endif>{{ $pref->name }}</option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('user_prefecture_id') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_address">住所(市町村以下、全角英数字不可)<span class="form_requires">*</span></label>
                                <input id="user_address" type="text" name="user_address" @if(old('user_address')!=null)value="{{ old('user_address') }}"@elseif(Auth::check()&&Auth::user()->address!=null)value="{{ Auth::user()->address }}"@endif @if ($errors->has('user_address')) class="input_alert" @endif placeholder="〇〇市〇〇町x-xx〇〇ハイツxxx号室" required>
                                @foreach ($errors->get('user_address') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_email">メールアドレス<span class="form_requires">*</span></label>
                                <input id="user_email" type="email" name="user_email" @if(old('user_email')!=null)value="{{ old('user_email') }}"@elseif(Auth::check()&&Auth::user()->email!=null)value="{{ Auth::user()->email }}"@endif @if ($errors->has('user_email')) class="input_alert" @endif placeholder="example@mail.com" required>
                                @foreach ($errors->get('user_email') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                            <li class="input_parts">
                                <label for="user_telephone">電話番号(ハイフン抜き)<span class="form_requires">*</span></label>
                                <input id="user_telephone" type="text" name="user_telephone" @if(old('user_telephone')!=null)value="{{ old('user_telephone') }}"@elseif(Auth::check()&&Auth::user()->telephone!=null)value="{{ Auth::user()->telephone }}"@endif @if ($errors->has('user_telephone')) class="input_alert" @endif placeholder="xxxxxxxxxx" required>
                                @foreach ($errors->get('user_telephone') as $item)
                                    <p class="form_alert">{{ $item }}</p>
                                @endforeach
                            </li>
                    </ul>
                </div>
            </div>
            @if ($lover!=null)
                <input type="hidden" name="lover_id" value="{{ $lover->id }}">
            @else
                <input type="hidden" name="lover_id" value="">
            @endif
            @if (Auth::check())
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @else
                <input type="hidden" name="user_id" value="">
            @endif
            <div class="btns">
                <button type="submit">次へ進む</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')