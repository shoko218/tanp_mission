<!DOCTYPE html>
<html lang="ja">
<head>
    @yield('head')
    @yield('css/js/meta')
</head>
<body>
    <div id="wrapper">
        @yield('header')
        @if (!Request::is('purchase/payment'))
            <div id="app">
        @endif
            <div id="contents">
                @yield('content')
            </div>

        @if (!Request::is('purchase/payment'))
            </div>
        @endif
        @yield('footer')
    </div>
</body>
</html>
