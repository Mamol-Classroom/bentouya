@extends('layout')

@section('title','トップページ')

@section('content')
<h1 style="text-align: center;">トップページ</h1>
<h3 style="text-align: center;">ログイン成功！ようこそ、{{$name}}様</h3>
    <a  href="/logout" >ログアウト</a><br><br>
    <a  href="/users-delete" >ユーザー情報削除</a><br><br>
    <a  href="/user-update">ユーザー情報更新</a><br><br>
    <a  href="/bento-manage">弁当販売管理</a><br><br>
    <a  href="/bento-buy-top">他社弁当購入</a><br><br>


@foreach($bentos as $bento)
    <table  style="border:1px solid black;border-collapse: collapse;">
        <tr>
        <tr>
            <td style="border:1px solid black;width:100px">ID:</td>
            <td style="border:1px solid black;width:250px">{{$bento['id']}}</td>
            <td style="border:1px solid black;width:100px">商品名:</td>
            <td style="border:1px solid black;width:250px">{{$bento['bento_name']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">価格：</td>
            <td style="border:1px solid black;width:250px">{{$bento['price']}}</td>
            <td style="border:1px solid black;width:100px">商品コード：</td>
            <td style="border:1px solid black;width:250px">{{$bento['bento_code']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">商品説明：</td>
            <td style="border:1px solid black;width:250px">{{$bento['description']}}</td>
            <td style="border:1px solid black;width:100px">賞味期限：</td>
            <td style="border:1px solid black;width:250px">{{$bento['guarantee_period']}}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:100px">在庫数：</td>
            <td style="border:1px solid black;width:250px">{{$bento['stock']}}</td>
            <td style="border:1px solid black;width:100px">登録者：</td>
            <td style="border:1px solid black;width:250px">{{$bento['user_id']}}</td>
        </tr>
        </tr>
    </table><br><br>

@endforeach






@endsection
