@extends('layout')

@section('title', 'パスワード変更')

@section('content')

<main id="main">
    <ul id="main-nav">
        <li><a href="/mypage">プロフィール</a></li>
        <li><a href="/mypage/password_reset">パスワード変更</a></li>
        <li><a href="">注文履歴</a></li>
        <li><a href="">注目リスト</a></li>
        <li><a href="">ポイント残高</a></li>
    </ul>

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
</main>
@endsection
