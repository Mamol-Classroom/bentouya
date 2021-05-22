<!Doctype html>
<html lang="ja">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="/css/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="logo"><a href="/"><img src="/img/logo.jpg" width="60px" height="auto"></a></div>
    <div class="profile">
        @if(auth()->check())
            <a class="cart" href="/cart"><i class="fas fa-shopping-cart"></i></a>
            <p>ようこそ、<img src="{{ auth()->user()->get_user_headPortrait_url() }}"> {{ auth()->user()->name }} 様</p>
                        <!--layout是top、mypage、bento页面共通的部分，如果需要后台引用，则需要在三个后台定义变量；
                        避免重复代码，可以直接从前台获取数据：auth()->user()->-->
            <a href="{{ route('get_logout') }}">ログアウト</a>
        @else
            <p>ようこそ、<img src="/img/default_profile_img.jpg" width="60px" heigth="auto"> ゲスト 様</p>
            <a href="{{ route('get_login') }}">ログイン</a>
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
<script src="/js/bentoDeleteConfirm.js"></script>
</body>
</html>
