
@extends('mypage.layout')

@section('title','注文履歴')


@section('mypage-content')
    <link rel="stylesheet" type="text/css" href="/css/cart.css">
    <body>

    @if(count($bentos) == 0)
        <a href="/">注文なし</a>
    @else

        <table>


            <tbody>
            @foreach($bentos as $bento)
                <tr class="trclass">
                    <td class="tdone"> <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/></td>
                    <td class="tdtwo ">
                        {{$bento->bento_name}}
                        <input type="hidden" name="bento_id" value="{{ $bento->id }}" />
                    </td>
                    <td class="tdthree">
            <span>
                <input class="quantity-reduce" name="click" type="button" value="-">
                <span class="cart-quantity">{{number_format($bento->quantity)}}</span>
                <input class="quantity-add" name="click" type="button" value="+">
            </span>
                    </td>
                    <td class="tdfour"><span>金額：</span><span class="subtal">{{ $bento->quantity * $bento->price }}</span></td>
                    <td class="tdfive"><span>注文日：¥</span><span class="date">{{number_format($bento->price)}}</span></td>
                    <td class="tdsix"><button class="delete">キャンセル</button></td>
                </tr>
            @endforeach
            <tr>
                <td   colspan="5" class="talast">
            <span>商品件数：
                <span class="goods_num">{{ $total_quantity }}</span> 件;
                合計金額：¥ <span class="pricetal">{{number_format($total_price)}}</span> ;
            </span>
                </td>
                <td>
                    <button type="button"><a href="/order">レジに進む</a></button>
                </td>
            </tr>
            </tbody>
        </table>

    @endif
    </body>
    <script src="/js/cart.js"></script>
@endsection
