@extends('layout')

@section('title', 'マイページ')

@section('content')

        <div class="subview">
            <h1>パスワード変更</h1>
            <div>
                <form method="post" action="/mypage/pw_update">
                    <table class="register-table">
                        <tr>
                            <td>現在のパスワード</td>
                            <td>
                                <input type="password" name="password" value="" />
                                @if(isset($error_message) && $error_message['password'] != null)
                                    <span class="error-message">{{ $error_message['password'] }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>新しいパスワード</td>
                            <td>
                                <input type="password" name="newpassword" value="{{ $data['newpassword'] }}" />
                                @if(isset($error_message) && $error_message['newpassword'] != null)
                                    <span class="error-message">{{ $error_message['newpassword'] }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>パスワードを確認</td>
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
                                <button type="submit" onclick="return del();">パスワードを変更</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
@endsection
