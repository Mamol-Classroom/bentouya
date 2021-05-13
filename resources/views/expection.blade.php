@extends('layout')

@section('title', 'マイページ')

@section('content')

    <main>
        <h1 class="center">注目リスト</h1><br>
    <div class="center">
      @if($wannaId==null)
           {!! お買い物を始めよう !!}
        @else
　　　　　   @foreach($wannaId as $key=>$wannaId)


          @endforeach
          @endif

</div>

    </main>



@endsection
