@extends('layout')

@section('title', '商品詳細')

@section('content')
    <main id="main">
        <div>
                <img src="{{ $bento_image_url }}">
        </div>
        <div class="subview">
            <h1>{{ $bento_name }}</h1>
            <h3>￥ {{ number_format($price) }}</h3>
            <p>商品コード：{{ $bento_code }}</p>
            <p>賞味期限：{{ $guarantee_period }}</p>
            <div>
                {!! nl2br($description) !!}
            </div>

            @if($bento_stock === 0)
                <p>在庫切れ</p>
            @else

            <form action="/add-to-cart" method="post">
                <input type="hidden" name="bento_id" value="{{ $bento_id }}">
                <label>
                    数量
                    <select name="quantity">
                        @for($i = 1; $i <= $bento_stock; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </label>
                <div>
                    <button type="submit">カートに追加</button>
                </div>
            </form>
            @endif
        </div>
    </main>
@endsection
