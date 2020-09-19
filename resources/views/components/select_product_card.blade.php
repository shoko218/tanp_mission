<div class="product_card">
    <a href="/select_product_detail?id={{ $product_id }}">
        <img src="/image/products/{{ sprintf('%05d', $product_id) }}.png" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
        </div>
    </a>
</div>