@extends('/layout')
@section('title','都道府県更新')
@section('content')
    <h1>都道府県更新</h1>
    <button><a type="button" href="/user-update">戻る</a></button>
    <br><br>
    @if (isset($error_msg)&&$error_msg!=null)
        <span style="color:red;">{{$error_msg}}</span>
    @endif
    <p style="color:red;">@error('prefecture'){{$message}}@enderror()</p>
    <form action="/prefecture-update" method="post">
        新しい都道府県：<input type="prefecture" name="prefecture"><br><br>
        <button type="submit" >更新</button>
    </form>





@endsection
