@extends('layout')

@section('title','弁当購入')

@section('content')
    <h1>弁当購入</h1>
    <button type="button"><a href="/top">戻る</a></button><br><br>
    @foreach($bentos as $bento)
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
                <td style="border:1px solid black;width:100px">在庫数：</td>
                <td style="border:1px solid black;width:250px">{{$bento->stock}}</td>
                <td style="border:1px solid black;width:100px">登録者：</td>
                <td style="border:1px solid black;width:250px">{{$bento->user_id}}</td>
            </tr>
            </tr>
        </table>
        @if($bento->stock>0)
            <form action="/bento-buy-confirm" method="post">
                <select name="quantity">
                    @for($i=1;$i<=$bento->stock;$i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
                <input type="hidden" name='bento_id' value="{{$bento->id}}">
                <input type="submit" value="購入">
            </form>
        @else
            <p style="color:red">在庫切れ</p>
        @endif

        <br><br><br>
    @endforeach




@endsection
