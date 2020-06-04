<a href="#">
    <div class="rank_card">
        <img src="{{ asset( 'image/products/'.$product_id.'.png',true)}}" alt="{{ $title }}" class="product_image">
        <div class="product_detail">
            <p class="rc_title">{{ $title }}</p>
            <p class="rc_genre">{{ $genre }}</p>
            <p class="rc_price">¥{{ $price }}</p>
        </div>
    </div>
</a>