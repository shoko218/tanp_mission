<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        <img src="{{ asset( 'image/products/'.sprintf('%05d', $product_id).'.png',true)}}" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}</p>
        </div>
    </a>
    <form action="/cart/out" class="cart_out_btn" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        @if (Auth::check())
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        @endif
        <button onClick="return confirm('削除します。\nよろしいですか？');" type="submit">削除</button>
    </form>
</div>