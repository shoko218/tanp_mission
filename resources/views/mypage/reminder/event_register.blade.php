@extends('layouts.base')

@section('pagename')
    イベント登録
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="event_register" class="normal_section">
        @include('components.msgs')
        <h1>新しいイベントを登録</h1>
        <p>全て入力してください。</p>
        <form action="/mypage/reminder/register_process" method="POST" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="lover_id">お相手</label>
                    <select id="lover_id" name="lover_id" required>
                        <option disabled selected value>選択してください</option>
                        @foreach ($lovers as $lover)
                        <option value="{{ $lover->id }}" @if(session('selected_lover_id')==$lover->id) selected @elseif(old('lover_id')==$lover->id) selected @endif>{{ $lover->last_name.$lover->first_name }}</option>
                        @endforeach
                    </select>
                    <a href="/mypage/lovers/register">お相手のご登録がお済みでない方はこちら</a>
                </li>
                <li class="input_parts">
                    <label for="title">イベント名(30文字以内)</label>
                    <input id="title" name="title" value="{{ old('title') }}" required>
                </li>
                <li class="input_parts">
                    <label for="scene_id">イベントの種類</label>
                    <select id="scene_id" name="scene_id" required>
                        <option disabled selected value>選択してください</option>
                        @foreach ($scenes as $scene)
                        <option value="{{ $scene->id }}" @if (old('scene_id')==$scene->id) selected @endif>{{ $scene->name }}</option>
                        @endforeach
                    </select>
                </li>
                <li class="input_parts">
                    <label for="date">日付</label>
                    <input type="date" name="date" value="{{ old('date') }}" min="<?php echo date('Y-m-d')?>" required>
                </li>
                <li class="radio_parts">
                    <p class="radiobtns_label">毎年繰り返しますか？</p>
                    <div class="radiobtns">
                        <label class="radio"><input type="radio" name="is_repeat" value="1" class="radiobtn" @if(old('repeat')==='1')checked="checked"@endif >はい</label>
                        <label class="radio"><input type="radio" name="is_repeat" value="0" class="radiobtn" @if(old('repeat')==='0')checked="checked"@endif>いいえ</label>
                    </div>
                </li>
            </ul>
            <div class="btns">
                <button>登録</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')