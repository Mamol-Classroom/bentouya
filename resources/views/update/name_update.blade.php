@extends('/layout')
@section('title','名前更新')
@section('content')
    <h1>名前更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('name'){{$message}}@enderror()</p>
    <form action="/name-update" method="post">
        新しい名前：<input type="name" name="name"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
