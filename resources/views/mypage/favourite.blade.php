@extends('mypage.layout')

@section('title','マイページ')

@section('mypage-content')

        @if(count($bentos) == 0)
            <p>弁当なし</p>
        @else

            <div class="subview">
                <h1 class="center">注目リスト</h1>

                <div class="bento-containter">

                    @foreach($bentos as $bento)

                            <div class="bento">
                                <div class="favor active" onclick="removeFavourite({{$bento->id}},this)"><i class="fas fa-heart"></i></div>

                            @include('subview.bento',['bento'=>$bento])
                               <!-- <a href="/bento/update?bento_id={{$bento->id}}">
                                    <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/>
                                    <p>{{$bento->bento_name}}</p>
                                    <p>¥{{number_format($bento->price)}}</p>
                                </a>-->
                            </div>

                    @endforeach
                </div>
    @endif
@endsection
