@extends('/layout')
@section('title','住所更新')
@section('content')
    <h1>住所更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('address'){{$message}}@enderror()</p>
    <form action="/address-update" method="post">
        新しい住所：<input type="address" name="address"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
