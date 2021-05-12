@extends('layout')

@section('title','favourite_list')

@section('content')
    @foreach($likes as $like)
        <div class="bento">
            <a href="/bento/update?bento_id={{ $like->bento_id }}">
                <p>{{ $like->bento_name }}</p>
                <p>￥ {{ number_format($like->price) }}</p>
            </a>
    @endforeach
@endsection
