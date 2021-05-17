@extends('layout')

@section('title', 'トップページ')

@section('content')
    <main>
        <h1 class="center">商品一覧</h1>
        <div id="search-block">
            <form method="get" action="/">
                <input type="text" name="word" value="{{ $word }}" placeholder="商品名" />
                <label>
                    価格範囲
                    <input class="inline-input" type="number" name="price_l" value="{{ $price_l }}" min="0" />
                    ~
                    <input class="inline-input" type="number" name="price_h" value="{{ $price_h }}" min="0" />
                </label>
                <button type="submit">検索</button>
            </form>
        </div>
        <div class="bento-container">
            @if(count($bentos) == 0)
                <p>弁当なし</p>
            @else
                @foreach($bentos as $bento)
                    <div class="bento">
                        @include('subview.bento',['bento'=>$bento])
                        <div class="favor @if($bento->is_favourite(auth()->id())) active @endif" onclick="addFavourite({{$bento->id}},this)"><i class="fas fa-star"></i></div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="paginate">
            <ul>
                <li><a href="{{ $bentos->withQueryString()->previousPageUrl() }}"><</a></li>
                @for($p = 1; $p <= ceil($bentos->total() / $bentos->perpage()); $p++)
                    <li><a href="{{ $bentos->withQueryString()->url($p) }}">{{ $p }}</a></li>
                @endfor
                <li><a href="{{ $bentos->withQueryString()->nextPageUrl() }}">></a></li>
            </ul>
        </div>
    </main>
@endsection

