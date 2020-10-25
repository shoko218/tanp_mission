<div class="product_card">
    <a href="/select_product_detail/{{ $url_str }}?id={{ $product_id }}">
        @if (env('APP_ENV') == 'production')
            <img src="{{ Storage::disk('s3')->url('products/'.sprintf('%05d', $product_id).'.png')}}" alt="{{ $title }}" class="product_card_img">
        @else
            <img src="/image/products/{{ sprintf('%05d', $product_id) }}.png" alt="{{ $title }}" class="product_card_img">
        @endif
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
        </div>
    </a>
</div>