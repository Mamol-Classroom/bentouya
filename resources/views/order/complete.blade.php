@extends('layout')

@section('title', '注文完了')

@section('content')
    <main class="center">

        <h1>注文完了</h1>

        <div>
        <p>{{$order_detail->name}}様,注文完了しました。ご購入誠にありがとうございました。</p>
        </div>

        <div>
            <p>配送先は下記になります</p>
            <table class="register-table">
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
                    <td>{{ $city}}</td>
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

        <div>
            <p>注文内容</p>
            <table class="register-table">
                <tr>
                    <td>弁当コード</td>
                    <td>{{$order_detail-> bento_id }}</td>
                </tr>
                <tr>
                    <td>弁当名</td>
                    <td>{{ $order_detail->bento_name }}</td>
                </tr>
                <tr>
                    <td>価格</td>
                    <td>{{ $order_detail->price }}</td>
                </tr>
                <tr>
                    <td>数量</td>
                    <td>{{$order_detail->quantity}}</td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>{{ $tel }}</td>
                </tr>
            </table>
        </div>
    </main>
@endsection

