@extends('layout')

@section('title','ユーザー削除失敗')

@section('content')
    <h1>ユーザー削除失敗</h1>
    <button type="button"><a href="/users-delete">戻る</a></button>
    <p style="color:red">削除失敗、該当ユーザーの売っている弁当を全て削除してください。</p>
@endsection
