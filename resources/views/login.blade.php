
@extends('layout')

@section('title','ログインページ')

@section('content')
<h1 style="text-align: center;">ログインページ</h1>
<form method="POST" action="/login" style="text-align: center;">
    @if($error_message)
        <p style="color:red">メールアドレスかパスワードが間違っています。</p>
    @endif
    メールアドレス：<br>
    <input type="email" name="email"><br><br>
    パスワード：<br>
    <input type="password" name="password"><br><br>

    <button type="submit" value="">ログイン</button><br><br><br>

    アカウントを持っていない方は：<button type="button" ><a href="/register">アカウント作成</a></button>









</form>









@endsection
