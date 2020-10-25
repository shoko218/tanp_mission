<div class="lover_card">
    <a href="/mypage/lovers/{{ $id }}" onclick="gtag('event','click', {'event_category': 'link','event_label': '大切な人の詳細ページ'});">
        @if (env('APP_ENV') === 'production')
            <img @if($img_path!=null) src="{{ Storage::disk('s3')->url('lover_imgs/'.$img_path)}}" @else src="{{ Storage::disk('s3')->url('lover_icons/noimage.png') }}" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
        @else
            <img @if($img_path!=null) src="/storage/lover_imgs/{{ $img_path }}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
        @endif
        <div class="lover_detail">
            <p class="lv_name">{{ $name }} さん</p>
            <p class="lv_relationship"><i class="fas fa-people-arrows"></i>{{ $relationship}}</p>
        </div>
    </a>
</div>