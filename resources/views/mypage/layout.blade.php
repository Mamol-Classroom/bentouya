@extends('layout')

@section('content')
    <main id="main">
        <ul id="main-nav">
            <li><a href="/mypage">プロフィール</a></li>
            <li><a href="">パスワード変更</a></li>
            <li><a href="">注文履歴</a></li>
            <li><a href="/favourite">注目リスト</a></li>
            <li><a href="">ポイント残高</a></li>
        </ul>

        @yield('mypage-content')
    </main>
@endsection