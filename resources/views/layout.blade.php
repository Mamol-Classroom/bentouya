<!Doctype html>
<html lang="ja">
<head>
    <title>新規登録</title>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<header>
    <div class="logo"><img src="/img/logo.jpg"width="100px"height="auto"></div>
    <div class="profile">

        @if(auth()->check())
        <p>ようこそ。{{ auth()->user()->name }}　様</p>
        <a href="/logout">ログアウト</a>
        @else
        <a href="/login">ログイン</a>
        @endif

    </div>
</header>

<nav>

    <ul>
        <li><a href="/">トップ</a></li>
        <li><a href="">マイページ</a></li>
        <li><a href="/bentos">商品管理</a></li>

    </ul>

</nav>
   @yield('content')
</body>
</html>
