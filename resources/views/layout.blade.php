<!Doctype html>
<html lang="ja">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <header>
        <div class="logo"><img src="/img/logo.jpg" width="100px" height="auto"></div>
        <div class="profile">
            @if(auth()->check())
                <p>ようこそ、{{ auth()->user()->name }} 様</p>
                <a href="/logout">ログアウト</a>
            @else
                <p>ようこそ、ゲスト 様</p>
                <a href="/login">ログイン</a>
            @endif
        </div>
    </header>
    @yield('content')
</body>
</html>
