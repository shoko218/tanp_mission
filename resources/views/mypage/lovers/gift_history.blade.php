@extends('layouts.base')

@section('pagename')
    {{ $name }}さんにいままであげたもの
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="gift_history" class="normal_section">
        @include('components.msgs')
        <h1>{{ $name }}さんにいままであげたもの</h1>
        @if (!$order_logs->isEmpty())
        <div id="orders">
            <div class="od_cards">
                @foreach ($order_logs as $order_log)
                @include('components.order_card',['product_id'=>$order_log->product_id,'title'=>$order_log->product->name,'date'=>$order_log->created_at,'person'=>$order_log->order->forwarding_last_name.$order_log->order->forwarding_first_name,'count'=>$order_log->count])
                @endforeach
            </div>
            {{$order_logs->appends(request()->input())->links()}}
        </div>
        @else
        @include('components.nothing_msgs')
        @endif
    </section>
@endsection

@include('layouts.footer')
