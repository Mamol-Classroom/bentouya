@extends('layout')

@section('title', '弁当登録完了')

@section('content')
    <main class="center">
        <h1>弁当登録完了</h1>
        <div>
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
                    <td>弁当コード</td>
                    <td>{{ $bento_code }}</td>
                </tr>
                <tr>
                    <td>説明</td>
                    <td>{!! nl2br($description) !!}</td>
                </tr>
                <tr>
                    <td>賞味期限</td>
                    <td>{{ $guarantee_period }}</td>
                </tr>
                <tr>
                    <td>在庫数</td>
                    <td>{{ $stock }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="/bentos">商品管理へ</a>
                    </td>
                </tr>
            </table>
        </div>
    </main>
@endsection
