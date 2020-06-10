@extends('layouts.base')

@section('pagename')
    大切な人登録
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lovers_register">
        <h1>新しく大切な人を登録</h1>
        <form action="#" method="POST">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="name">お名前</label>
                    <input id="name" name="name" value="{{ old('name') }}" required placeholder="お名前を入力してください">
                </li>
                <li class="input_parts">
                    <label for="sex">性別</label>
                    <select id="sex" name="sex" value="{{ old('sex') }}" required>
                        <option disabled selected value>選択してください</option>
                        <option value="">男</option>
                        <option value="">女</option>
                        <option value="">その他</option>
                    </select>
                </li>
                <li class="input_parts">
                    <label for="birthday">お誕生日</label>
                    <input type="date" name="birthday" value="{{ old('birthday') }}" required>
                </li>
                <li class="input_parts">
                    <label for="relationship">お相手との関係性</label>
                    <select id="relationship" name="relationship" value="{{ old('relationship') }}" required>
                        <option disabled selected value>選択してください</option>
                        <option value="">恋人</option>
                        <option value="">配偶者</option>
                        <option value="">親</option>
                        <option value="">兄弟姉妹</option>
                        <option value="">祖父母</option>
                        <option value="">子供</option>
                        <option value="">孫</option>
                        <option value="">甥姪</option>
                        <option value="">友人</option>
                        <option value="">上司</option>
                        <option value="">同僚</option>
                        <option value="">部下</option>
                        <option value="">その他</option>
                    </select>
                </li>
            </ul>
            <div class="btns">
                <button>登録</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')