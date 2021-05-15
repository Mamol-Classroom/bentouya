@extends('layout')

@section('title', '商品詳細')

@section('content')
    <main id="main">
        <div></div>
        <div class="subview">
            <h1>{{ $bento_name }}</h1>
            <h3>￥ {{ number_format($price) }}</h3> <!--数字分隔符-->
            <p>商品コード：{{ $bento_code }}</p>
            <p>賞味期限：{{ $guarantee_period }}</p>
            <div>
                {!! nl2br($description) !!} <!--将用户输入的回车转换为php语言，并保持类型一致-->
            </div>
        </div>
    </main>
@endsection
