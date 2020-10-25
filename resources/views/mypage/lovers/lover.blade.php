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
                    @if (env('APP_ENV') === 'production')
                        <img @if($img_path!=null) src="{{ Storage::disk('s3')->url('lover_imgs/'.$img_path)}}" @else src="{{ Storage::disk('s3')->url('lover_icons/noimage.jpg') }}" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_img">
                    @else
                        <img @if($img_path!=null) src="/storage/lover_imgs/{{ $img_path }}" @else src="/image/lover_icons/noimage.jpg" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_img">
                    @endif
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
                    <button type="submit" onclick="gtag('event','click', {'event_category': 'link','event_label': '今まであげたもの一覧'});location.href='/mypage/lovers/{{ $id }}/gift_history'">今まであげたもの</button>
                </div>
                <p class="submit_a"><a href="/mypage/lovers/{{ $id }}/edit">登録情報を確認・編集する</a></p>
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
            @include('components.lover_recommend_product_card',['product_id'=>$product->id,'title'=>$product->name,'genre'=>$product->genre->name,'price'=>$product->price])
            @endforeach
        </div>
        <div class="btns">
            <button onclick="location.href='/result'">プレゼントを探しに行く→</button>
        </div>
    </section>
    @endif
@endsection

@include('layouts.footer')