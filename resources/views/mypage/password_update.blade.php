@extends('layout')

@section('title','マイページ')

@section('content')

    <main id="main">
        <ul id="main-nav">
            <li><a href="/mypage">プロフィール</a></li>
            <li><a href="/mypage/password-update" >パスワード変更</a></li>
            <li><a href="">注文履歴</a></li>
            <li><a href="">注目リスト</a></li>
            <li><a href="">ポイント残高</a></li>
        </ul>

        <div class="subview">
            <h1>プロフィール</h1>
            <div>
                <form method="post" action="/mypage/password-update">
                    <table class="register-table">
                        <tr>
                            <td>新しいパスワード</td>
                            <td>
                                <input type="password" name="password" value="{{ $data['password'] }}" />
                                @if(isset($error_message) && $error_message['password'] != null)
                                    <span class="error-message">{{ $error_message['password'] }}</span>
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



    </main>






@endsection
