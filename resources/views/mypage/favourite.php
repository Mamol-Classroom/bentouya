@extends('layout')

@section('title', '注目リスト')

@section('content')
<main id="main">
    <ul id="main-nav">
        <li><a href="">プロフィール</a></li>
        <li><a href="">パスワード変更</a></li>
        <li><a href="">注文履歴</a></li>
        <li><a href="">注目リスト</a></li>
        <li><a href="">ポイント残高</a></li>
    </ul>

    <div class="subview">
        <h1>注目リスト</h1>
        @if(count($bentos) == 0)
        <p>注目なし</p>
        @else
        @foreach($bentos as $bento)
        <div class="bento">
            <div class="favor active" onclick="removeFavourite({{ $bento->id }}, this)"><i class="fas fa-heart"></i></div>
            <a href="/bento/{{ $bento->id }}/detail">
                <p>{{ $bento->bento_name }}</p>
                <p>￥ {{ number_format($bento->price) }}</p>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</main>
@endsection
