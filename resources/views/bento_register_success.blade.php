@extends('layout')

@section('title', '弁当登録完了')

@section('content')
    <main class="center">
        <h1>弁当登録完了</h1>
        <div>
            <p>登録情報は下記になります</p>
            <table class="register-table">
                <tr>
                    <td>弁当名</td>
                    <td>{{ $bento_name }}</td>
                </tr>
                <tr>
                    <td>価格</td>
                    <td>{{ $price }}</td>
                </tr>
                <tr>
                    <td>商品コード</td>
                    <td>{{ $bento_code}}</td>
                </tr>
                <tr>
                    <td>商品説明</td>
                    <td>{{ $description}}</td>
                </tr>
                <tr>
                    <td>賞味期限</td>
                    <td>{{ $guarantee_period }}</td>
                </tr>
                <tr>
                    <td>在庫数</td>
                    <td>{{ $stock}}</td>
                </tr>
                <tr>
                    <td>ユーザーID</td>
                    <td>{{ $user_id }}</td>
                </tr>
            </table>
        </div>
    </main>
@endsection
