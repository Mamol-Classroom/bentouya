@extends('layout')

@section('title','マイページ')

@section('content')

    <main id="main">
        <ul id="main-nav">
            <li><a href="/mypage">プロフィール</a></li>
            <li><a href="/mypage/password-update" >パスワード変更</a></li>
            <li><a href="">注文履歴</a></li>
            <li><a href="/favourite">注目リスト</a></li>
            <li><a href="">ポイント残高</a></li>
        </ul>

            <div class="subview">
                <h1 class="center">注目リスト</h1>

                <div class="bento-containter">

                    @foreach($bentos as $bento)

                            <div class="bento">
                                <div class="favor"><i class="fas fa-heart"></i></div>
                                <a href="/bento/detail/{{$bento->id}}">
                                    <p>{{$bento->bento_name}}</p>
                                    <p>¥{{number_format($bento->price)}}</p>
                                </a>
                            </div>





                    @endforeach
                </div>
