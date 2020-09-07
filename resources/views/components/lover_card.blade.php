<form method="post" name="form{{ $order }}" action="/mypage/lovers/lover" class="lover_card">
    @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <a href="javascript:form{{ $order }}.submit()">
            <img @if($ext!=null) src="{{ asset('/storage/'.sprintf('%09d', $lover->id).'.'.$ext.'?'.uniqid())}}?" @else src="{{ asset( 'image/lover_icons/noimage.png',true)}}" @endif alt="{{ $name }}" class="lover_card_img">
            <div class="lover_detail">
                <p class="lv_name">{{ $name }} さん</p>
                <p class="lv_relationship"><i class="fas fa-people-arrows"></i>{{ $relationship}}</p>
            </div>
        </a>
</form>