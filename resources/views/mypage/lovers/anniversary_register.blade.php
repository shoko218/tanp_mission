@extends('layouts.base')

@section('pagename')
    にしむらりなさん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="anniversary_register">
        <img src="{{ asset( 'image/lover_icons/test.png',true)}}" alt="にしむらりなさん" id="anniversary_register_img">
        <p id="anniversary_register_name">にしむらりな さん</p>
        <form action="#" method="POST">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="anniverasry_name">記念日名</label>
                    <input id="anniverasry_name" name="anniverasry_name" value="{{ old('anniverasry_name') }}" required autofocus>
                </li>
                <li class="input_parts">
                    <label for="anniverasry_genre">記念日の種類</label>
                    <select id="anniverasry_genre" name="anniverasry_genre" value="{{ old('anniverasry_genre') }}" required>
                        <option value="">誕生日</option>
                        <option value="">記念日</option>
                        <option value="">結婚記念日</option>
                        <option value="">クリスマス</option>
                        <option value="">バレンタイン</option>
                        <option value="">ホワイトデー</option>
                        <option value="">母の日</option>
                        <option value="">父の日</option>
                        <option value="">敬老の日</option>
                        <option value="">サプライズ</option>
                        <option value="">プロポーズ</option>
                        <option value="">その他</option>
                    </select>
                </li>
                <li class="input_parts">
                    <label for="date">日付</label>
                    <input type="date" name="date" value="{{ old('date') }}" required>
                </li>
            </ul>
            <div class="btns">
                <button>登録</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')