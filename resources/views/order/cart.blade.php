@extends('layout')

@section('title','カート')

@section('content')
    <main id="main">
        <div id="cart-item-controller">
            <div class="bento-container">
                @if(count($bentos) == 0)  //收藏bento数量count为0
                    <a href="/">買い物を続ける</a>
                @else
                    @foreach($bentos as $bento)
                        <div class="bento">
                            <a href="/bento/{{$bento->id}}/detail">  <!--与include内的内容不一样，需要单独书写-->
                                <img src="{{$bento->get_bento_image_url()}}" style="width:180px;" />
                                <p>{{$bento->bento_name}}</p>
                                <p>合計:￥ {{number_format($bento->price)}}</p>
                                <p>数量: {{number_format($bento->quantity)}}</p>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div id="cart-btn-controller">
            <p>￥ {{number_format($total_price)}}</p>
            <button type="button">レジに進む</button>
        </div>
    </main>
@endsection
