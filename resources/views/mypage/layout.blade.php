@extends('layout')

@section('content')
    <main id="main">
        <ul id="main-nav">
            <li><a href="/mypage/update">個人情報変更</a></li>
            <li><a href="/mypage/password_change">パスワード変更</a></li>
            <li><a href="/mypage/order_list">注文履歴</a></li>
            <li><a href="/mypage/favourite">注目リスト</a></li>
            <li><a href="">ポイント残高</a></li>
        </ul>
        @yield('mypage-content')
    </main>
@endsection()
