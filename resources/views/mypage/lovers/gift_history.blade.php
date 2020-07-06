@extends('layouts.base')

@section('pagename')
    {{ $name }}さんにいままであげたもの
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="gift_history">
        <h1>{{ $name }}さんにいままであげたもの</h1>
        <div id="orders">
            @if (!$order_logs->isEmpty())
            <div id="od_cards">
                @foreach ($order_logs as $order_log)
                @include('components.order_card',['product_id'=>$order_log->product_id,'title'=>$order_log->product->name,'date'=>$order_log->created_at,'person'=>$order_log->order->last_name.$order_log->order->first_name,'count'=>$order_log->count])
                @endforeach
            </div>
            @else
                <p class="nothing_msg">まだ商品はありません。</p>
            @endif
        </div>
    </section>
@endsection

@include('layouts.footer')