<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        @if (env('APP_ENV') == 'production')
            <img src="{{ Storage::disk('s3')->url('products/'.sprintf('%05d', $product_id).'.jpg')}}" alt="{{ $title }}" class="product_card_img">
        @else
            <img src="/image/products/{{ sprintf('%05d', $product_id) }}.jpg" alt="{{ $title }}" class="product_card_img">
        @endif
        <div class="product_detail">
            <p class="od_title">{{ $title }}</p>
            <p class="od_for">{{ $person }}さんへ</p>
            <p class="od_count">数量:{{ $count }}</p>
            <p class="od_date">注文日:{{ $date->format('Y年m月d日') }}</p>
        </div>
    </a>
</div>