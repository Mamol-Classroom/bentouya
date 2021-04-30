@extends('layout')

@section('title', 'トップページ')

@section('content')
    <h1>トップページ</h1>

     <p>ようこそ。{{$name}}　様</p>

    <a href="/logout">ログアウト</a>
@endsection
