@section('header')
    <header>
        <a href="/"><img src="{{ asset( 'image/logo.png',true)}}" alt="ロゴ" class="logo"></a>
        <div class="header_btns">
            <button onfocus="this.blur();">
                <img src="{{ asset( 'image/icons/cart.png',true)}}" alt="cart" class="header_icon">
            </button>
            <button onfocus="this.blur();">
                <img src="{{ asset( 'image/icons/menu.png',true)}}" alt="menu" class="header_icon">
            </button>
        </div>
    </header>
@endsection