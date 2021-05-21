@extends('layout')

@section('title', '弁当管理')

@section('content')
    <main id="main">
        <ul id="main-nav">
            <li><a href="/bento/add">商品追加</a></li>
        </ul>
        <div class="subview">
            <h1 class="center">弁当管理</h1>
            <div class="bento-container">
                @foreach($bentos as $bento)
                    <div class="bento">
                        @include('subview.bento', ['bento' => $bento])
                        <form method="post" action="/bento/delete">
                            <input type="hidden" name="bento_id" value="{{ $bento->id }}">
                            <button type="submit">販売終了</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
