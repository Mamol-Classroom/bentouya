@extends('layout')

@section('title', 'カート')

@section('content')
<div id="cart">
    @if(count($bentos) == 0)
        <a href="/">買い物を続ける</a>
    @else
        <table>
            <thead>
            <tr>
                <th class="tdone">画像</th>
                <th class="tdtwo">商品名</th>
                <th class="tdthree">数量</th>
                <th class="tdfour">単価</th>
                <th class="tdfive">価格</th>
                <th class="tdsix">操作</th>
            </tr>
            </thead>

            <tbody>
            @foreach($bentos as $bento)
                <tr class="trclass">
                    <td class="tdone"> <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/></td>
                    <td class="tdtwo">{{$bento->bento_name}}</td>
                    <td class="tdthree"><span><input type="button" value="-"><span class="num">{{number_format($bento->quantity)}}</span><input type="button" value="+"></span></td>
                    <td class="tdfour"><span>単価：¥</span><span class="unit">{{number_format($bento->price)}}</span></td>
                    <td class="tdfive"><span>小計：</span><span class="subtal">0</span></td>
                    <td class="tdsix"><button>キャンセル</button></td>
                </tr>
            @endforeach
            <tr><td colspan="6" class="talast"><span>商品件数：<span class="goods_num">0</span> 件; 合計金額： <span class="pricetal">{{number_format($total_price)}}</span> 円; </span></td></tr>
            </tbody>
        </table>

    @endif

    <div >
        <p>¥{{number_format($total_price)}}</p>
        <button type="button">レジに進む</button>
    </div>
</div>
@endsection
