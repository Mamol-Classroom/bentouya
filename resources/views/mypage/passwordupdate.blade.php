@extends('layout')

@section('title', 'マイページ')

@section('content')
    <main id="main">
        <ul id="main-nav">
            <li><a href="">プロフィール</a></li>
            <li><a href="">パスワード変更</a></li>
            <li><a href="">注文履歴</a></li>
            <li><a href="">注目リスト</a></li>
            <li><a href="">ポイント残高</a></li>
        </ul>

        <div class="subview">
            <h1>パスワード変更</h1>
            <div>
                <form method="post" action="/mypage/passwordupdate">
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
    </main>
@endsection
