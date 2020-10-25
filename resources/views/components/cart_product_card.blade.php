<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        <img src="/image/products/{{ sprintf('%05d', $product_id) }}.jpg" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}(+tax)</p>
        </div>
    </a>
    <form action="/cart/complete_out" class="remove_product_btn" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        @if (Auth::check())
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        @endif
        <button onClick="return confirm('削除します。\nよろしいですか？');" type="submit">×</button>
    </form>
    <div class="cart_change_count">
        <form action="/cart/minus" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            @if (Auth::check())
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endif
            <button class="cart_minus_btn" @if ($count==1) onClick="return confirm('削除します。\nよろしいですか？');"@endif>-</button>
        </form>
        <p>{{ $count }}</p>
        <form action="/cart/plus" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            @if (Auth::check())
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endif
            <button @if ($count>254) class="cart_cannot_plus_btn" type="button" @else class="cart_plus_btn" @endif >+</button>
        </form>
    </div>
</div>