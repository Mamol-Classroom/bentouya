@extends('layout')

@section('title','ユーザー情報削除')

@section('content')
<h1>ユーザー情報削除</h1>
<button type="button"><a href="/top">戻る</a></button><br><br>
@if(isset($error_message)&&$error_message!=null)
{{$error_message}}
@endif
<form action="/users-delete-action" method="post">
    ユーザーID：<select name="id">
        @foreach($user_ids as $id)
            <option value={{$id}}>{{$id}}</option>

        @endforeach
    </select>
    <input type="submit" value="削除">
</form>
@endsection
