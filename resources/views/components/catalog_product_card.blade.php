<div class="product_card product_in_catalog_card">
    <a href="/product?id={{ $product_id }}">
        <img src="{{ asset( 'image/products/'.sprintf('%05d', $product_id).'.png',true)}}" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}(+tax)</p>
        </div>
    </a>
    <form action="/mypage/original_catalog/remove_process" class="remove_product_btn" method="POST">
        @csrf
        <input type="hidden" name="catalog_id" value="{{ $catalog_id }}">
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        <button onClick="return confirm('削除します。\nよろしいですか？');" type="submit">×</button>
    </form>
</div>