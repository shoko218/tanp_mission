@section('header')
    <header>
        <div class="header_contents">
            <a href="/">
                @if(env('APP_ENV') == 'production')
                    <img src="{{ Storage::disk('s3')->url('/image/logo.png')}}" alt="ロゴ" class="logo">
                @else
                    <img src="/image/logo.png" alt="ロゴ" class="logo">
                @endif
            </a>
            <div class="header_btns">
                <button onfocus="this.blur();" onclick="location.href='/cart'">
                    <img src="/image/icons/cart.png" alt="cart" class="header_icon">
                </button>
                <button onfocus="this.blur();" id="hb_menu_btn">
                    <img src="/image/icons/menu.png" alt="menu" class="header_icon" id="hb_menu_btn_img">
                </button>
            </div>
        </div>
    </header>
    <nav id="hb_menu" class="hb_menu_close">
        @if (Auth::check())
            <p>こんにちは、{{ Auth::user()->last_name.Auth::user()->first_name }}さん</p>
            <ul>
                <li><a href="/">トップページ</a></li>
                <li><a href="/mypage/order_history">注文履歴</a></li>
                <li><a href="/mypage/reminder/top">イベントリマインダー</a></li>
                <li><a href="/mypage/lovers/top">大切な人リスト</a></li>
                <li><a href="/mypage/favorite">お気に入り</a></li>
                <li><a href="/mypage/original_catalog/top">オリジナルカタログ</a></li>
                <li><a href="/mypage/register_info/top">登録確認/修正/退会</a></li>
                <li><a href="/logout">ログアウト</a></li>
            </ul>
        @else
            <p>こんにちは、ゲストさん</p>
            <ul>
                <li><a href="/">トップページ</a></li>
                <li><a href="/login">ログイン</a></li>
                <li><a href="/register">新規登録</a></li>
            </ul>
        @endif
    </nav>
    <div id="darker"></div>
@endsection