@extends('layouts.base')

@section('pagename')
    オリジナルカタログの確認・編集
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
<section id="fillin_info" class="normal_section">
    <h1>オリジナルカタログを確認・編集する</h1>
    <p>全て入力してください。</p>
        <form method="POST" action="/mypage/original_catalog/edit_process" class="input_form">
            @csrf
            <ul class="inputs">
                <li class="input_parts">
                    <label for="name">お相手の名前</label>
                    <input id="name" type="text" name="name" @if (old('name')!=null) value="{{ old('name') }}" @elseif($catalog->name!=null)
                     value="{{ $catalog->name }}" @endif placeholder="山田太郎" required  @if ($errors->has('name')) class="input_alert" @endif>
                     @foreach ($errors->get('name') as $item)
                         <p class="form_alert">{{ $item }}</p>
                     @endforeach
                </li>
                <li class="input_parts">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email"  @if (old('email')!=null) value="{{ old('email') }}" @elseif($catalog->email!=null)
                    value="{{ $catalog->email }}" @endif placeholder="example@mail.com" required autocomplete="email" @if ($errors->has('email')) class="input_alert" @endif>
                    @foreach ($errors->get('email') as $item)
                        <p class="form_alert">{{ $item }}</p>
                    @endforeach
                </li>
                <catalog-img-component :err-msgs='@json($errors->get('img_num'))' @if($catalog->img_num!=null) :old-img-num='@json((string)$catalog->img_num)'  @elseif(old('img_num')==null) :old-img-num='@json('0')' @else :old-img-num='@json(old('img_num'))'@endif></catalog-img-component>
            </ul>
            <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
            <div class="btns">
                <button type="submit">変更する</button>
            </div>
        </form>
    </section>
@endsection

@include('layouts.footer')