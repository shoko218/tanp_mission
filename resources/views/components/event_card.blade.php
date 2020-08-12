<form method="post" name="form{{ $order }}" action="/mypage/reminder/detail" class="event_card">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">
    <a href="javascript:form{{ $order }}.submit()">
        <img src="{{ asset( 'image/lover_icons/noimage.png',true)}}" alt="{{ $name }}さん" class="event_card_img">
        <div class="event_detail">
            <p class="an_date">{{ $date }}</p>
            <p class="an_event">{{ $title }}</p>
            <p class="an_person"><i class="fas fa-user"></i>{{ $name }} さん</p>
        </div>
    </a>
</form>