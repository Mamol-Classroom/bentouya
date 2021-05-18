@extends('layout')

@section('title', 'マイページ')

@section('content')

    <main>
        <h1 class="center">注目リスト</h1><br>
    <div class="center">
      @if(empty($bentos))
            お買い物を始めよう
        @else
　　　　　   @foreach($bentos as $bento)
            弁当名：{{ $bento->bento_name }}<br>
            価格：{{ number_format($bento->price) }}<br>
          @endforeach
          @endif

</div>

    </main>



@endsection
