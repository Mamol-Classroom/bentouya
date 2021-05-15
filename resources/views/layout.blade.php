<!Doctype html>
<html lang="ja">
<head>
    <title>新規登録</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="/css/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="logo"><img src="/img/logo.jpg"width="100px"height="auto"></div>
    @if(auth()->check())
    <div class="avatar"><img src="storage/{{ auth()->user()->avatar }}" width="60px"height="60px"></div>
    @endif

    <div class="profile">

        @if(auth()->check())
        <p>ようこそ。{{ auth()->user()->name }}　様</p>
        <a href="/logout">ログアウト</a>
        @else
        <a href="/login">ログイン</a>
        @endif

    </div>
</header>


@if(auth()->check())
<nav>
    <ul>
        <li><a href="/">トップ</a></li>
        <li><a href="/mypage">マイページ</a></li>
        <li><a href="/bentos">商品管理</a></li>

    </ul>
</nav>
@endif
   @yield('content')

<script src="/js/script.js"></script>
</body>
</html>
