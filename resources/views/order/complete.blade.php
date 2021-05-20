@extends('layout')

@section('title', '注文完了')

@section('content')
    <main class="center">
        <link rel="stylesheet" type="text/css" href="/css/cart.css">
        <h1>注文完了</h1>

        <div>
        <p>{{$name}}様,注文完了しました。ご購入誠にありがとうございました。</p>
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
            <table>
                <thead>
                <tr>
                    <th class="tdone">画像</th>
                    <th class="tdtwo">商品名</th>
                    <th class="tdthree">数量</th>
                    <th class="tdfour">単価</th>
                    <th class="tdfive">価格</th>

                </tr>
                </thead>

                <tbody>
                @foreach($order_detail_list as $order_detail)
                    <tr class="trclass">
                        <td class="tdone"> <img src="{{$order_detail-> bento_img }}" style="width: 180px; height:135px "/></td>
                        <td class="tdtwo ">{{$order_detail-> bento_id}}</td>
                        <td class="tdthree">{{ $order_detail->bento_name }}</td>
                        <td class="tdfour">{{number_format($order_detail->price)}}</td>
                        <td class="tdfive">{{$order_detail->quantity}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>




        </div>
    </main>
@endsection

