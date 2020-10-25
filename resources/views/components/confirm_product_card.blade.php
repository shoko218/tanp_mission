<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        <img src="/image/products/{{ sprintf('%05d', $product_id) }}.jpg" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}(+tax)</p>
            <p class="rc_count">数量:{{ $count }}</p>
        </div>
    </a>
</div>