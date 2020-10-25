<div class="product_card">
    <a href="/product?id={{ $product_id }}" onclick="gtag('event','click', {'event_category': 'link','event_label': '商品閲覧'});">
        @if (env('APP_ENV') == 'production')
            <img src="{{ Storage::disk('s3')->url('products/'.sprintf('%05d', $product_id).'.jpg')}}" alt="{{ $title }}" class="product_card_img">
        @else
            <img src="/image/products/{{ sprintf('%05d', $product_id) }}.jpg" alt="{{ $title }}" class="product_card_img">
        @endif
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ number_format($price) }}(+tax)</p>
        </div>
    </a>
</div>