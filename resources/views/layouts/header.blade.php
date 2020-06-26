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
        @if (Auth::check())
            <p><a href="/mypage/top">こんにちは、{{ Auth::user()->last_name.Auth::user()->first_name }}さん</a></p>
            <ul>
                <li><a href="/">トップページ</a></li>
                <li><a href="/mypage/order_history">注文履歴</a></li>
                <li><a href="/mypage/reminder/top">イベントリマインダー</a></li>
                <li><a href="/mypage/lovers/top">大切な人リスト</a></li>
                <li><a href="/mypage/favorite">お気に入り</a></li>
                <li><a href="/mypage/register_info/top">登録確認/修正/退会</a></li>
                <li><a href="/logout">ログアウト</a></li>
            </ul>
        @else
            <p><a href="/mypage/top">こんにちは、ゲストさん</a></p>
            <ul>
                <li><a href="/">トップページ</a></li>
                <li><a href="/login">ログイン</a></li>
                <li><a href="/register">新規登録</a></li>
            </ul>
        @endif
    </nav>
    <div id="darker"></div>
@endsection