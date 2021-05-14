@extends('layout')

@section('title', '弁当管理')

@section('content')
    <main id="main">
        <ul id="main-nav">
            <li><a href="/bento/add">商品追加</a></li>
        </ul>
        <div class="subview">
        <script type="text/javascript" src="/js/confirm.js"></script>
        <h1 class="center">弁当管理</h1>
        <div class="bento-container">
            @foreach($bentos as $bento)
                <div class="bento">
                    <a href="/bento/update?bento_id={{ $bento->id }}">
                        <p>{{ $bento->bento_name }}</p>
                        <p>￥ {{ number_format($bento->price) }}</p>
                    </a>
                    <form onsubmit="return del()" method="post" action="/bento/delete">
                        <input type="hidden" name="bento_id" value="{{ $bento->id }}">
                        <button type="submit">販売終了</button>
                    </form>
                <!--<form method="post" action="/bento/delete">
                        <input type="hidden" name="bento_id" value="{{ $bento->id }}">
                        <button type="submit" onclick= "return del()">販売終了</button>
                    </form>-->
                </div>
            @endforeach
        </div>
        </div>
    </main>
@endsection

