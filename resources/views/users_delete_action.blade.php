@extends('layout')

@section('title','ユーザー情報削除確認')

@section('content')
<h1>ユーザー情報削除確認</h1>
<table>
    <tr>
        <th>ユーザー情報</th>
    </tr>
    <tr>
        <td>メールアドレス </td>
        <td>{{$email}}</td>

    </tr>
    <tr>
        <td>パスワード</td>
        <td>
            ***********
        </td>

    </tr>
    <tr>
        <td>郵便番号</td>
        <td>{{$postcode}}</td>

    </tr>
    <tr>
        <td>都道府県</td>
        <td>{{$prefecture}}</td>

    </tr>
    <tr>
        <td>市区町村</td>
        <td>{{$city}}</td>

    </tr>
    <tr>
        <td>電話番号</td>
        <td>{{$tel}}</td>

    </tr>
    <tr>
        <td>名前</td>
        <td>{{$name}}</td>

    </tr>
    <tr>
        <td>住所</td>
        <td>{{$address}}</td>

    </tr>
</table>
<form action="/users-delete-success" method="post">
    <input type="hidden" name="id" value={{$id}}>
    <input type="submit" value="削除" >
</form><br>
<button type="button"><a href="/users-delete">キャンセル</a></button>

@endsection
