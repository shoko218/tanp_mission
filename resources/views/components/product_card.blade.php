<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        <img src="{{ asset( 'image/products/'.sprintf('%05d', $product_id).'.png',true)}}" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}</p>
        </div>
    </a>
</div>