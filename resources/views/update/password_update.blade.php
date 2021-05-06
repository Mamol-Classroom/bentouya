@extends('/layout')
@section('title','パスワード更新')
@section('content')
    <h1>パスワード更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('password'){{$message}}@enderror()</p>
    <form action="/password-update" method="post">
        新しいパスワード：<input type="password" name="password"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
