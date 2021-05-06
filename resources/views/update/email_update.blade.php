@extends('/layout')
@section('title','メールアドレス更新')
@section('content')
    <h1>メールアドレス更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
    <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('email'){{$message}}@enderror()</p>
    <form action="/email-update" method="post">
        新しいメールアドレス：<input type="email" name="email"><br><br>
        <button type="submit" >更新</button>
    </form>






@endsection
