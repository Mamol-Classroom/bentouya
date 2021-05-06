@extends('/layout')
@section('title','電話番号更新')
@section('content')
    <h1>電話番号更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('tel'){{$message}}@enderror()</p>
    <form action="/tel-update" method="post">
        新しい電話番号：<input type="tel" name="tel"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
