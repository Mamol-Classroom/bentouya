@extends('/layout')
@section('title','弁当購入確認')
@section('content')
<h1>弁当購入確認</h1>
<button type="button"><a href="/bento-buy-top">戻る</a></button><br><br>
    <table  style="border:1px solid black;border-collapse: collapse;">
        <tr>
        <tr>
            <td style="border:1px solid black;width:100px">ID:</td>
            <td style="border:1px solid black;width:250px">{{$bento->id}}</td>
            <td style="border:1px solid black;width:100px">商品名:</td>
            <td style="border:1px solid black;width:250px">{{$bento->bento_name}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">価格：</td>
            <td style="border:1px solid black;width:250px">{{$bento->price}}</td>
            <td style="border:1px solid black;width:100px">商品コード：</td>
            <td style="border:1px solid black;width:250px">{{$bento->bento_code}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">商品説明：</td>
            <td style="border:1px solid black;width:250px">{{$bento->description}}</td>
            <td style="border:1px solid black;width:100px">賞味期限：</td>
            <td style="border:1px solid black;width:250px">{{$bento->guarantee_period}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">購買数：</td>
            <td style="border:1px solid black;width:250px">{{$quantity}}</td>
            <td style="border:1px solid black;width:100px">登録者：</td>
            <td style="border:1px solid black;width:250px">{{$bento->user_id}}</td>
        </tr>
        </tr>
    </table>
    <p>請求額：{{number_format($quantity*$bento->price)}}円</p>
    <form action="/bento-buy-success" method="post" >
        <input type="hidden" name="stock" value="{{$bento->stock}}">
        <input type="hidden" name="bento_id" value="{{$bento->id}}">
        <input type="hidden" name="quantity" value="{{$quantity}}">
        <input type="submit" value="購入確定">
    </form>

@endsection
