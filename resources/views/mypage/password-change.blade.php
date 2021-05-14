@extends('mypage.layout')

@section('title','パスワード変更')

@section('mypage-content')
    <div class="subview">
        <h1>パスワード変更</h1>
        <div>
            <form method="post" action="/mypage/password-change">
                <table class="register-table">
                    <tr>
                        <td>元パスワード</td>
                        <td>
                            <input type="password" name="password" value=""/>
                            @if(isset($error_message)&&$error_message['password'] != null)
                                <span class="error-message">{{$error_message['password']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>パスワード変更</td>
                        <td>
                            <input type="password" name="password_change" value="@if($data != null){{$data['password_change']}}@endif"/>
                            @if(isset($error_message)&&$error_message['password_change'] != null)
                                <span class="error-message">{{$error_message['password_change']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>パスワード確認</td>
                        <td>
                            <input type="password" name="password_change_confirm" value="@if($data != null){{$data['password_change_confirm']}}@endif" />
                            @if(isset($error_message)&&$error_message['password_change_confirm'] != null)
                                <span class="error-message">{{$error_message['password_change_confirm']}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" onclick="return del();">確認</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
