@extends('mypage.layout')

@section('title','パスワード変更')

@section('mypage-content')
    <div class="subview">
        <h1>パスワードの変更</h1>
        <div>
            <form method="post" action="/mypage/password_update">
                <table class="register-table">
                    <tr>
                        <td>現在のパスワード</td>
                        <td>
                            <input type="password" name="password" value=""/>
                            @if(isset($error_message)&&$error_message['password'] != null)
                                <span class="error-message">{{$error_message['password']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>新しいパスワード</td>
                        <td>
                            <input type="password" name="new_password" value="@if($data != null){{$data['new_password']}}@endif"/>
                            @if(isset($error_message)&&$error_message['new_password'] != null)
                                <span class="error-message">{{$error_message['new_password']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>パスワードを確認</td>
                        <td>
                            <input type="password" name="password_confirm" value="@if($data != null){{$data['password_confirm']}}@endif" />
                            @if(isset($error_message)&&$error_message['password_confirm'] != null)
                                <span class="error-message">{{$error_message['password_confirm']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" onclick="return del();">パスワードを変更へ</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
