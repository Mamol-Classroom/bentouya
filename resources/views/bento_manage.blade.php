@extends('layout')
@section('title','弁当管理')
@section('content')
<h1>弁当管理システム</h1>
<button type="button"><a href="/top">戻る</a></button><br><br>
<button type="button" ><a href="/bento-add">弁当登録</a></button><br><br>

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
            <table>
                <tr>
                    <td style="width:100px">
                        <form action="/bento-update" method="post">
                            <input type="hidden" name=id value="{{$bento->id}}">
                            <input type="hidden" name=bento_name value="{{$bento->bento_name}}">
                            <input type="hidden" name=price value="{{$bento->price}}">
                            <input type="hidden" name=bento_code value="{{$bento->bento_code}}">
                            <input type="hidden" name=description value="{{$bento->description}}">
                            <input type="hidden" name=guarantee_period value="{{$bento->guarantee_period}}">
                            <input type="hidden" name=stock value="{{$bento->stock}}">
                            <input type="hidden" name=user_id value="{{$bento->user_id}}">
                            <input type='submit' value="商品編集"><br><br>
                        </form>
                    </td>
                    <td style="width:250px"></td>
                    <td style="width:100px">
                        <form action="/bento-delete" method="post">
                            <input type="hidden" name=id value="{{$bento->id}}">
                            <input type='submit' value="商品削除"><br><br>
                        </form>
                    </td>
                    <td style="width:250px"></td>
                </tr>
            </table><br><br>



        @endforeach








@endsection
