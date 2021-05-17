<a href="/bento/{{ $bento->id }}/detail">
    <img src="{{ $bento->get_bento_image_url() }}" style="width: 180px;" />
    <p>{{ $bento->bento_name }}</p>
    <p>￥ {{ number_format($bento->price) }}</p>
</a>
