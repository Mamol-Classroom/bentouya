@extends('mypage.layout')

@section('title','注文履歴')

@section('mypage-content')
    <link rel="stylesheet" type="text/css" href="/css/cart.css">
    <h1>注文履歴</h1>
    <div>
        <table>
            <thead>
            <tr>
                <th>注文番號</th>
                <th>{{ $order_id}}</th>
            </tr>
            <tr>
                <th class="tdone">画像</th>
                <th class="tdtwo">商品名</th>
                <th class="tdthree">数量</th>
                <th class="tdfour">単価</th>
                <th class="tdfive">価格</th>
            </tr>
            </thead>

            <tbody>
            @foreach($bentos as $bento)
                <tr class="trclass">
                    <td class="tdone"> <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/></td>
                    <td class="tdtwo ">{{$bento_name}}</td>
                    <td class="tdthree">{{number_format($quantity)}}</td>
                    <td class="tdfour"><span>単価：¥</span><span class="unit">{{number_format($price)}}</span></td>
                    <td class="tdfive"><span>小計：¥</span><span class="subtal">{{ number_format($quantity *$price) }}</span></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="talast">
                        <span>商品件数：
                            <span class="goods_num">{{ $total_quantity }}</span> 件;
                            合計金額：¥<span class="pricetal">{{ number_format($total_price) }}</span> 円;
                        </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <script src="/js/cart.js"></script>


    </div>



@endsection
