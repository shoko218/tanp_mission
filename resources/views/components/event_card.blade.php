<form method="post" name="form{{ $order }}" action="/mypage/reminder/detail" class="event_card">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">
    <a href="javascript:form{{ $order }}.submit()" class="event_card_contents">
        @if (env('APP_ENV') === 'production')
            <img @if($ext!=null) src="{{ Storage::disk('s3')->url('lover_imgs/'.sprintf('%09d', $lover_id)).'.'.$ext}}?{{ uniqid() }}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
        @else
            <img @if($ext!=null) src="/storage/lover_imgs/{{ sprintf('%09d', $lover_id).'.'.$ext.'?'.uniqid() }}" @else src="/image/lover_icons/noimage.png" @endif alt="{{ $name }}" alt="{{ $name }}さん" class="lover_card_img">
        @endif
        <div class="event_detail">
            <p class="an_date">{{ $date }}</p>
            <p class="an_event">{{ $title }}</p>
            <p class="an_person"><i class="fas fa-user"></i>{{ $name }} さん</p>
        </div>
    </a>
</form>