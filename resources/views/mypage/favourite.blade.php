@extends('mypage.layout')

@section('title','注目リスト')

@section('mypage-content')
    <div class="subview">
        <h1>注目リスト</h1>
        @if(count($bentos) == 0)
            <p>注目リスト</p>
        @else
            @foreach($bentos as $bento)
            <div class="bento">
                <div class="favor active" onclick="removeFavourite({{ $bento->id }},this)"><i class="fas fa-heart"></i></div>
                @include('subview.bento',['bento' => $bento])
            </div>
            @endforeach
        @endif
    </div>
@endsection
