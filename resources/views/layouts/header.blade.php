@section('header')
    <header>
        <a href="/"><img src="{{ asset( 'image/logo.png',true)}}" alt="ロゴ" class="logo"></a>
        <div class="header_btns">
            <button onfocus="this.blur();" onclick="location.href='/cart'">
                <img src="{{ asset( 'image/icons/cart.png',true)}}" alt="cart" class="header_icon">
            </button>
            <button onfocus="this.blur();" id="hb_menu_btn">
                <img src="{{ asset( 'image/icons/menu.png',true)}}" alt="menu" class="header_icon" id="hb_menu_btn_img">
            </button>
        </div>
    </header>
    <nav id="hb_menu" class="hb_menu_close">
        <p><a href="/mypage/top">こんにちは、〇〇さん</a></p>
        <ul>
            <li><a href="/">トップページ</a></li>
            <li><a href="/mypage/order_history">注文履歴</a></li>
            <li><a href="/mypage/reminder">記念日リマインダー</a></li>
            <li><a href="/mypage/lovers">大切な人リスト</a></li>
            <li><a href="/mypage/favorite">お気に入り</a></li>
            <li><a href="#">登録確認/修正/退会</a></li>
            <li><a href="#">ログアウト</a></li>
        </ul>
    </nav>
    <div id="darker"></div>
@endsection