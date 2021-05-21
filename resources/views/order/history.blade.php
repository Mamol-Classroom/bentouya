@extends('mypage.layout')

@section('title','注文履歴')

@section('mypage-content')
    <main id="order-history">
        <h1>注文履歴</h1>
        <div class="history-container">
            @foreach($orders as $order)
                <div class="order-container">
                    <div class="order-info">
                        <span class="order-time">{{ $order->created_at }}</span>
                        <span class="order-total">￥{{ number_format($order->get_total_price()) }}</span>
                    </div>
                    <div class="order-detail">
                        @foreach($order->get_order_details() as $order_detail)
                            <a href="/bento/{{ $order_detail->bento_id }}/detail">
                                <div class="order-bento">
                                    <div class="bento-img-container"><img src="{{ $order_detail->get_bento_img() }}"></div>
                                    <div class="bento-info-container">
                                        <p>{{ $order_detail->bento_name }}</p>
                                        <p>￥ {{ number_format($order_detail->price) }}</p>
                                        <p>数量：{{ number_format($order_detail->quantity) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
