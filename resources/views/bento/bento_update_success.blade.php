@extends('/layout')
@section('title','弁当編集')
@section('content')
<h1>弁当編集完了</h1>
<table>
    <tr>
        <td>商品名：</td>
        <td>{{$bento_name}}</td>
    </tr>
    <tr>
        <td>価格：</td>
        <td>{{$price}}</td>
    </tr>
    <tr>
        <td>商品コード：</td>
        <td>{{$bento_code}}</td>
    </tr>
    <tr>
        <td>賞味期限：</td>
        <td>{{$guarantee_period}}</td>
    </tr>
    <tr>
        <td>在庫数：</td>
        <td>{{$stock}}</td>
    </tr>
    <tr>
        <td>登録者：</td>
        <td>{{$user_id}}</td>
    </tr>
    <tr>
        <td>商品説明：</td>
        <td>{{$description}}</td>
    </tr>









</table>
<a href="/bento-manage">戻る</a>
@endsection
