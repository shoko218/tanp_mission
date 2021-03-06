@extends('layouts.base')

@section('pagename')
    お気に入り
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="favorite" class="normal_section">
        <h1>お気に入り</h1>
        @if (count($favorite_products))
            <div id="favorites">
                <div class="oc_cards">
                    @foreach ($favorite_products as $favorite_product)
                    @include('components.product_card',['product_id'=>$favorite_product->id,'title'=>$favorite_product->name,'genre'=>$favorite_product->genre->name,'price'=>$favorite_product->price])
                    @endforeach
                </div>
            </div>
            {{ $favorite_products->links() }}
        @else
            @include('components.nothing_msgs')
        @endif
    </section>
@endsection

@include('layouts.footer')
