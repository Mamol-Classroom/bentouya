@extends('mypage.layout')

@section('title','マイページ')

@section('mypage-content')

    <div class="subview">
        <h1>パスワード変更</h1>
        <div>
            <form method="post" action="/mypage/password-update">
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
                        <td>新しいパスワード</td>
                        <td>
                            <input type="password" name="new_password" value="{{ $data['new_password'] }}" />
                            @if(isset($error_message) && $error_message['new_password'] != null)
                                <span class="error-message">{{ $error_message['new_password'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>パスワード確認</td>
                        <td>
                            <input type="password" name="password_confirm" value="{{ $data['password_confirm'] }}" />
                            @if(isset($error_message) && $error_message['password_confirm'] != null)
                                <span class="error-message">{{ $error_message['password_confirm'] }}</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">確認</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
