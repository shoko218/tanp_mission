@section('header')
    <header>
        <a href="/"><img src="{{ asset( 'image/logo.png',true)}}" alt="ロゴ" class="logo"></a>
        <div class="header_btns">
            <button onfocus="this.blur();">
                <img src="{{ asset( 'image/icons/cart.png',true)}}" alt="cart" class="header_icon">
            </button>
            <button onfocus="this.blur();" id="hb_menu_btn">
                <img src="{{ asset( 'image/icons/menu.png',true)}}" alt="menu" class="header_icon" id="hb_menu_btn_img">
            </button>
        </div>
    </header>
    <div id="hb_menu" class="hb_menu_close">
        <p>こんにちは、〇〇さん</p>
        <ul>
            <a href="#"><li>注文履歴</li></a>
            <a href="#"><li>記念日リマインダー</li></a>
            <a href="#"><li>お気に入り</li></a>
            <a href="#"><li>登録確認/修正/退会</li></a>
            <a href="#"><li>ログアウト</li></a>
        </ul>
    </div>
    <div id="darker"></div>
@endsection