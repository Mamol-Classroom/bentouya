@extends('layout')

@section('title','弁当管理')

@section('content')
    <script type="text/javascript" src="/js/confirm.js"></script>
    <main>
        <h1 class="center">弁当管理</h1>

        <div class="bento-containter">

            @foreach($bentos as $bento)
                <div class="bento">
                    <a href="/bento/update?bento_id={{$bento->id}}">
                        <p>{{$bento->bento_name}}</p>
                        <p>¥{{number_format($bento->price)}}</p>
                    </a>


                    <form onsubmit="return del()" method="post" action="/bento/delete">
                        <input type="hidden" name="bento_id" value="{{$bento->id}}">
                        <button  type="submit">販売終了</button>
                    </form>




                </div>
            @endforeach
        </div>





    </main>




    <br>
    <div class="center">
        <a href="/bento/add">新規弁当登録</a>
    </div>







@endsection
