@extends('mypage.layout')

@section('title','パスワード変更')

@section('mypage-content')

    <div class="subview">
        <h1>パスワード変更</h1>
        <div>
            <form method="post" action="/mypage/password_reset">
                <table class="register-table">
                    <tr>
                        <td>新しいパスワード</td>
                        <td>
                            <input type="text" name="password_reset" value="@if($password_reset != null){{ $password_reset['password_reset'] }}@endif" />
                            @if(isset($error_message) && $error_message['password_reset'] != null)
                                <span class="error-message">{{ $error_message['password_reset'] }}</span>
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
