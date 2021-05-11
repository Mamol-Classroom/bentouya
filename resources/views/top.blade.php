@extends('layout')

@section('title', 'トップページ')

@section('content')
    <main>
        <h1 class="center">商品一覧</h1>
        <div id="search-block">
            <form method="get" action="/">
                <input type="text" name="word" value="{{ $word }}" placeholder="商品名" />
                <button type="submit">検索</button>
            </form>
        </div>
        <div class="bento-container">
            @if(count($bentos) == 0)
                <p>弁当なし</p>
            @else
                @foreach($bentos as $bento)
                    <div class="bento">
                        <p>{{ $bento->bento_name }}</p>
                        <p>￥ {{ number_format($bento->price) }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
@endsection

