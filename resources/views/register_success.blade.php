@extends('layout')

@section('title','註冊成功')

@section('content')
    <h1>登録した内容以下</h1>
<main>
    <table>
        <p>メールアドレス:{{$email}}</p>
        <p>名前:{{$name}}</p>
        <p>郵便番号:{{$postcode}}</p>
        <p>都道府県:{{$prefecture}}</p>
        <p>市区町村:{{$city}}</p>
        <p>住所:{{$address}}</p>
        <p>電話番号:{{$tel}}</p>
    </table>
    <button type="button" onclick."location.href =''"><</button>
</main>



@endsection
