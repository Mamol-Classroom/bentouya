@extends('layout')

@section('title', '弁当管理')

@section('content')
    <script type="text/javascript" src="/js/bentoDeleteConfirm.js"></script>
    <main id="main">
        <ul id="main-nav">
            <li><a href="/bento/add">商品追加</a></li>
        </ul>
        <div class="subview">
            <h1 class="center">弁当管理</h1>
            <div class="bento-container">
                @foreach($bentos as $bento)
                    <div class="bento">
                        {{--<a href="/bento/update?bento_id={{ $bento->id }}">
                            <!--将bento的id反馈在url上为了区分便当的id；也可以写成bento/updete/?bento_id=-->
                            <p>{{ $bento->bento_name }}</p>
                            <p>￥ {{ number_format($bento->price) }}</p>
                        </a>--}}
                        @include('bento/bento_inf_include',['bento'=>$bento])
                        <!--$bento可以不传值，因为include里边的$bento会自动传进来-->
                        <form method="post" action="/bento/delete">
                            <input type="hidden" name="bento_id" value="{{ $bento->id }}">
                            <button type="submit"  onclick="return del();">販売終了</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
