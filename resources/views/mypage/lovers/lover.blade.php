@extends('layouts.base')

@section('pagename')
    大切な人-{{ $name }}さん
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="lover" class="normal_section">
        @include('components.msgs')
        <div class="lover_detail_top">
            <div class="lover_details">
                <p class="img_container">
                    <img @if($ext!=null) src="/storage/lover_imgs/{{ sprintf('%09d', $id).'.'.$ext.'?'.uniqid() }}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_img">
                </p>
                <p class="lover_name">{{ $name }}さん</p>
            </div>
            <div class="lover_actions">
                <div class="lover_btns">
                    <form method="post" name="register_event_form" id="register_event_form" action="/mypage/reminder/register">
                        @csrf
                        <input type="hidden" name="lover_id" value="{{ $id }}">
                        <button type="submit" form="register_event_form">イベント登録+</button>
                    </form>
                    <form action="/mypage/lovers/gift_history" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="name" value="{{ $name }}">
                        <button type="submit">今まであげたもの</button>
                    </form>
                </div>
                <form method="post" name="edit_form" id="edit_form" action="/mypage/lovers/edit">
                    @csrf
                    <input type="hidden" name="lover_id" value="{{ $id }}">
                </form>
                <p class="submit_a"><a href="javascript:edit_form.submit()">登録情報を確認・編集する</a></p>
                <form method="post" name="delete_form" id="delete_form" action="/mypage/lovers/delete_process">
                    @csrf
                    <input type="hidden" name="lover_id" value="{{ $id }}">
                </form>
                <p class="submit_a"><a href="javascript:delete_form.submit()" onClick="return confirm('大切な人リストから削除します。\nよろしいですか？');">大切な人リストから削除する</a></p>
            </div>
        </div>
    </section>
    @if ($products!=null)
    <section class="recommend_rank">
        <h2>{{ $name }}さんにおすすめのプレゼント</h2>
        <div class="rc_cards">
            @foreach ($products as $product)
            @include('components.product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/result'">プレゼントを探しに行く→</button>
        </div>
    </section>
    @endif
@endsection

@include('layouts.footer')