@extends('/layout')
@section('title','市区町村更新')
@section('content')
    <h1>市区町村更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('city'){{$message}}@enderror()</p>
    <form action="/city-update" method="post">
        新しい市区町村：<input type="city" name="city"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
