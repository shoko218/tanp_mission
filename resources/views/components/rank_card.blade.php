<div class="rank_card">
    <a href="/product?id={{ $product_id }}">
        <img src="{{ asset( 'image/products/'.$product_id.'.png',true)}}" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ $price }}</p>
        </div>
    </a>
</div>