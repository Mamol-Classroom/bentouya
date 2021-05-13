@extends('layout')

@section('title', 'トップページ')

@section('content')
    <main>
        <h1 class="center">商品一覧</h1>
        <div class="bento-container">
            @foreach($bentos as $bento)
                <div class="bento">
                    <p>{{ $bento->bento_name }}</p>
                    <p>{{ number_format($bento->price) }}</p>
                </div>
            @endforeach
        </div>
    </main>
@endsection
