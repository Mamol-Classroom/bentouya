@extends('layout')

@section('title', '商品詳細')

@section('content')
    <main id="main">
        <div></div>
        <div>
            <img src="{{$bento_image_url}}">  <!--添加bento图片：bug非默认图片大小不可控-->
        </div>
        <div class="subview">
            <h1>{{ $bento_name }}</h1>
            <h3>￥ {{ number_format($price) }}</h3> <!--数字分隔符-->
            <p>商品コード：{{ $bento_code }}</p>
            <p>賞味期限：{{ $guarantee_period }}</p>
            <div>
                {!! nl2br($description) !!} <!--将用户输入的回车转换为php语言，并保持类型一致-->
            </div>

            @if($bento_stock === 0)
                <p>在庫切れ</p>
            @else
                <form method="post" action="/add-to-cart">
                    <input type="hidden" name="bento_id" value="{{$bento_id}}">
                    <label>
                        数量
                        <select name="quantity">
                            @for($i = 1;$i <= $bento_stock;$i++)  <!--最大选择为在库数-->
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
