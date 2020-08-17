@extends('layouts.base')

@section('pagename')
    新規オリジナルカタログ
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="fillin_info" class="normal_section">
    <h1>オリジナルカタログを作成</h1>
    <p>全て入力してください。</p>
        <form method="POST" action="register_process" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="name">お相手の名前</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="山田太郎" required autofocus @if ($errors->has('name')) class="input_alert" @endif>
                    @foreach ($errors->get('name') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" required autocomplete="email" @if ($errors->has('email')) class="input_alert" @endif>
                    @foreach ($errors->get('email') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <li class="input_parts">
                    <label for="img_num">イメージ画像</label>
                    <select name="img_num" id="img_num">
                        <option value="" selected disabled @if ($errors->has('img_num')) class="input_alert" @endif>選択してください</option>
                        @for ($i = 0; $i < 16; $i++)
                        <option value="{{ $i+1 }}"@if(old('img_num')==$i+1) selected @endif>{{ $i+1 }}</option>
                        @endfor
                    </select>
                    @foreach ($errors->get('img_num') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
            </ul>
            <div class="btns">
                <button type="submit">登録</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')