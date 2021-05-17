@extends('layout')

@section('title', 'トップページ')

@section('content')

    <main>
        <h1 class="center">商品一覧</h1>
        <div id="search-block">
            <form method="get" action="/">
                <input type="text" name="word" value="{{$word}}" placeholder="商品名"/>
                <label>

                    価格範囲
                    <input class="inline-input" type="number" name="price_l" value="{{ $price_l }}" min="0"/>
                    ~
                    <input class="inline-input" type="number" name="price_h" value="{{ $price_h }}" min="0"/>

                </label>

                <button type="submit">検索</button>
            </form>
        </div>

        @if($add_to_cart_bento_id != null)
            <div class="alert-msg">
                <img src="{{$add_to_cart_bento_id->get_bento_image_url()}}" style="width:60px">
                <span>カートに追加しました</span>
            </div>
        @endif


        <div class="bento-containter">
            @if(count($bentos) == 0)
                <p>弁当なし</p>
            @else
            @foreach($bentos as $bento)
                <div class="bento">
                    <div class="favor @if($bento->is_favourite(auth()->id())) active @endif" onclick="addFavourite({{$bento->id}},this)"><i class="fas fa-heart"></i></div>
                @include('subview.bento',['bento'=>$bento])
                   <!--问号换斜杠 直接通过路由传参数 <a href="/bento/detail?id={/{//$bento->id}}">-->
                     <!--  <a href="/bento/detail/{{$bento->id}}">
                           <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/>
                        <p>{{$bento->bento_name}}</p>
                        <p>¥{{number_format($bento->price)}}</p>
                    </a>-->
                </div>
            @endforeach

            @endif
        </div>

        <div class="paginate">
            <ul>
                <li><a href="{{ $bentos->previousPageUrl() }}"><</a></li>
                @for($p = 1; $p <= ceil($bentos->total() / $bentos->perpage()); $p++)
                    <li><a href="{{ $bentos->url($p) }}">{{ $p }}</a></li>
                @endfor
                <li><a href="{{ $bentos->nextPageUrl() }}">></a></li>
            </ul>
        </div>
    </main>



@endsection
