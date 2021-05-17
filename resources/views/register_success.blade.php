@extends('layout')

@section('title', '登録完了')

@section('content')
    <main class="center">
        <h1>登録完了</h1>
        <div>
            <p>登録情報は下記になります</p>
            <table class="register-table">
                <tr>
                    <td>メールアドレス</td>
                    <td>{{ $email }}</td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td>{{ $name }}</td>
                </tr>
                <tr>
                    <td>ユーザー画像</td>
                    <td><img src="{{ $headPortrait_url }}"></td>  <!--页面内的变量是控制器里的key而不是变量本身-->
                </tr>
                <tr>
                    <td>郵便番号</td>
                    <td>{{ $postcode }}</td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td>{{ $prefecture }}</td>
                </tr>
                <tr>
                    <td>市区町村</td>
                    <td>{{ $city }}</td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td>{{ $address }}</td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>{{ $tel }}</td>
                </tr>
            </table>
        </div>
        <a href="/login"><button type="submit">登録画面へ</button></a>
    </main>
@endsection
