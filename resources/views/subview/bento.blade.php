<!--问号换斜杠 直接通过路由传参数 <a href="/bento/detail?id={/{//$bento->id}}">-->
<!--<a href="/bento/update?bento_id={{$bento->id}}">-->
<a href="/bento/detail/{{$bento->id}}">
    <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px; height:135px "/>
    <p>{{$bento->bento_name}}</p>
    <p>¥{{number_format($bento->price)}}</p>
</a>
