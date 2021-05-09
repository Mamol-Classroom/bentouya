@extends('layout')

@section('title','弁当管理')

@section('content')

    <main>
        <h1 class="center">弁当管理</h1>

        <div class="bento-containter">

            @foreach($bentos as $bento)
                <div class="bento">
                    <a href="/bento/update?bento_id={{$bento->id}}">
                        <p>{{$bento->bento_name}}</p>
                        <p>¥{{number_format($bento->price)}}</p>
                    </a>
                    <form method="post" action="/bento/delete">
                        <input type="hidden" name="bento_id" value="{{$bento->id}}">
                     <button type="submit">販売終了</button>
                    </form>
                </div>
            @endforeach
        </div>
    </main>












@endsection
