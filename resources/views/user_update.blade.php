@extends('layout')
@section('title','ユーザー情報更新')
@section('content')
    <link rel="stylesheet" href="/css/user_update.css">
    <h1>ユーザー情報更新</h1>

        <table>
            <tr>
                <th>ユーザー情報</th>
            </tr>
            <tr>
                <td>メールアドレス </td>
                <td>{{$email}}</td>
                <td>
                    <button type="button"><a href="/email-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>パスワード</td>
                <td>
                    ***********
                </td>
                <td>
                    <button type="button"><a href="/password-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>郵便番号</td>
                <td>{{$postcode}}</td>
                <td>
                    <button type="button"><a href="/postcode-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>都道府県</td>
                <td>{{$prefecture}}</td>
                <td>
                    <button type="button"><a href="/prefecture-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>市区町村</td>
                <td>{{$city}}</td>
                <td>
                    <button type="button"><a href="/city-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>{{$tel}}</td>
                <td>
                    <button type="button"><a href="/tel-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>名前</td>
                <td>{{$name}}</td>
                <td>
                    <button type="button"><a href="/name-update">編集</a></button>
                </td>
            </tr>
            <tr>
                <td>住所</td>
                <td>{{$address}}</td>
                <td>
                    <button type="button"><a href="address-update">編集</a></button>
                </td>
            </tr>




    <button style="display:block" type="button" ><a href="/top">戻る</a></button>
















@endsection
