<div class="product_card">
    <a href="/product?id={{ $product_id }}">
        <img src="{{ asset( 'image/products/'.$product_id.'.png',true)}}" alt="{{ $title }}" class="product_card_img">
        <div class="product_detail">
            <p class="od_title">{{ $title }}</p>
            <p class="od_date">注文日:{{ $date }}</p>
            <p class="od_for">{{ $person }}さんに{{ $event }}のプレゼントとして</p>
        </div>
    </a>
</div>