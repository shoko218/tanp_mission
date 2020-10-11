<form method="post" name="form{{ $order }}" action="/mypage/lovers/lover" class="lover_card">
    @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <a href="javascript:form{{ $order }}.submit()">
            @if (env('APP_ENV') === 'production')
                <img @if($img_path!=null) src="{{ Storage::disk('s3')->url('lover_imgs/'.$img_path)}}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
            @else
                <img @if($img_path!=null) src="/storage/lover_imgs/{{ $img_path }}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
            @endif
            <div class="lover_detail">
                <p class="lv_name">{{ $name }} さん</p>
                <p class="lv_relationship"><i class="fas fa-people-arrows"></i>{{ $relationship}}</p>
            </div>
        </a>
</form>