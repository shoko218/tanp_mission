<!DOCTYPE html>
<html lang="ja">
<head>
    @yield('head')
    @yield('css/js/meta')
</head>
<body>
    <div id="wrapper">
        @yield('header')
        <div id="contents">
            @include('components.errmsg')
            @yield('content')
        </div>
        @yield('footer')
    </div>
</body>
</html>