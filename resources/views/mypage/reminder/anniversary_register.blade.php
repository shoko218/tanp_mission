@extends('layouts.base')

@section('pagename')
    記念日登録
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="anniversary_register">
        <h1>新しい記念日を登録</h1>
        <form action="#" method="POST">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="name">お相手</label>
                    <select id="name" name="name" value="{{ old('name') }}" required>
                        <option disabled selected value>選択してください</option>
                        <option value="">りな</option>
                        <option value="">お母さん</option>
                        <option value="">お父さん</option>
                    </select>
                </li>
                <a href="/mypage/lovers/register">お相手のご登録がお済みでない方はこちら</a>
                <li class="input_parts">
                    <label for="title">記念日名</label>
                    <input id="title" name="title" value="{{ old('title') }}" required>
                </li>
                <li class="input_parts">
                    <label for="genre">記念日の種類</label>
                    <select id="genre" name="genre" value="{{ old('genre') }}" required>
                        <option disabled selected value>選択してください</option>
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