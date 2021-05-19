@extends('layout')

@section('title', 'トップページ')

@section('content')
    <main>
        <h1 class="center">商品一覧</h1>
        <div id="search-block"> <!--检索栏-->
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
        @if($add_to_cart_bento != null)  <!--将加入购物车的商品显示到top页面-->
            <div class="alert-msg">
                <img src="{{$add_to_cart_bento->get_bento_image_url()}}" style="width:60px;" />
                <span>カートに追加しました</span>
                <p>{{$add_to_cart_bento->bento_name}}</p> {{--获取商品名称和购买数量：这里没有quantity，需要在添加购物车时flash过来--}}
                <p>数量: {{number_format($add_to_cart_bento_quantity)}}</p>
            </div>
        @endif
        <div class="bento-container"> <!--商品展示-->

            @if(count($bentos) == 0)
                <p>弁当なし</p>
            @else
                @foreach($bentos as $bento)
                    <div class="bento">
                        <!--在显示便当循环中套用jquery，触发onclick事件，插入图标i，this指当前user-->
                        <div class="favor" onclick="addFavourite({{ $bento->id }}, this)"><i class="fas fa-heart"></i></div>
                        <!--this不在php脚本内，是js语言，指代的是onclick事件触发时的自己，即div->script.js的icon-->
                        <div class="favor @if($bento->is_favourite(auth()->id())) active @endif" onclick="addFavourite({{$bento->id}},this)"><i class="fas fa-heart"></i></div>
                        <!--跟top.blade的收藏便当更改图标进行同步，更改Bento数据库-->
                        <!--删除css class：style.css中的active->图标变灰-->
                        {{--<a href="/bento/{{ $bento->id }}/detail">  <!--跳转到便当详情detail页面-->
                            <!--将bento的id反馈在url上为了区分便当的id；另一种写法在bento.index和bento.update中-->
                            <p>{{ $bento->bento_name }}</p>
                            <p>￥ {{ number_format($bento->price) }}</p>
                        </a>--}}
                        @include('bento/bento_inf_include',['bento'=>$bento])
                    </div>
                @endforeach
            @endif

        </div>
        <div class="paginate"> <!--页面翻转-->
            <ul>         <!--TopConcoller的paginate-->
                <li><a href="{{ $bentos->withQueryString()->previousPageUrl() }}"><</a></li> <!--laravel向前跳转页面-->
                @for($p = 1; $p <= ceil($bentos->total() / $bentos->perpage()); $p++)
                    <!--ceil向上取整&total便当总数除以perpage每页展示数-->
                    <li><a href="{{ $bentos->withQueryString()->url($p) }}">{{ $p }}</a></li>
                    <!--url链接-->
                @endfor
                <li><a href="{{ $bentos->withQueryString()->nextPageUrl() }}">></a></li>     <!--laravel向后跳转页面-->
                    <!--withQueryString:将筛选之后的bento数据返还给url，携带数据跳转,避免换页后丢失筛选数据无法翻页-->
            </ul>
        </div>
    </main>
@endsection
