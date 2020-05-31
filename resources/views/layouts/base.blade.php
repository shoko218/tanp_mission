<!DOCTYPE html>
<html lang="ja">
<head>
    @yield('head')
</head>
<body>
    <div id="wrapper">
        @yield('header')
        <div id="contents">
            @yield('content')
        </div>
        @yield('footer')
    </div>
</body>
</html>