<form method="post" name="form" action="/mypage/reminder/detail" class="event_card">
    @csrf
    <input type="hidden" name="lover_id" value="{{ $id }}">
    <input type="hidden" name="name" value="{{ $name }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="scene_id" value="{{ $scene_id }}">
    <a href="javascript:form[{{ $order }}].submit()">
        <img src="{{ asset( 'image/lover_icons/noimage.png',true)}}" alt="{{ $name }}さん" class="event_card_img">
        <div class="event_detail">
            <p class="an_date">{{ $date }}</p>
            <p class="an_event">{{ $scene }}</p>
            <p class="an_person"><i class="fas fa-user"></i>{{ $name }} さん</p>
        </div>
    </a>
</form>