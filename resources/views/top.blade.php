@extends('layout')

@section('title', 'トップページ')

@section('content')
    <header>
       <div class="logo"><img src="/img/logo.jpg"width="100px"height="auto"></div>
        <div class="profile">
        <p>ようこそ。{{$name}}　様</p>
        <a href="/logout">ログアウト</a>
        </div>
    </header>

    <main>
        <h1 class="center">商品一覧</h1>

        <div class="bento-containter">

            @foreach($bentos as $bento)
                <div class="bento">
                    <p>{{$bento->bento_name}}</p>
                    <p>¥{{number_format($bento->price)}}</p>
                </div>
            @endforeach
        </div>
    </main>

    <a href="/bento_register">弁当登録</a>
@endsection
