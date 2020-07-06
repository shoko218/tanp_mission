@extends('layouts.base')

@section('pagename')
    注文履歴
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="order_history">
        <h1>注文履歴</h1>
        <div id="orders">
            <div id="od_cards">
                @foreach ($order_logs as $order_log)
                @include('components.order_card',['product_id'=>$order_log->product_id,'title'=>$order_log->product->name,'date'=>$order_log->created_at,'person'=>$order_log->order->last_name.$order_log->order->first_name,'count'=>$order_log->count])
                @endforeach
            </div>
            {{ $order_logs->links() }}
        </div>
    </section>
@endsection

@include('layouts.footer')