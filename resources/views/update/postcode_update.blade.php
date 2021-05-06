@extends('/layout')
@section('title','郵便番号更新')
@section('content')
    <h1>郵便番号更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('postcode'){{$message}}@enderror()</p>
    <form action="/postcode-update" method="post">
        新しい郵便番号：<input type="postcode" name="postcode"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
