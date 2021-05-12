@extends('layout')

@section('title','パスワード変更')

@section('content')
    <main name="main">
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
                <form method="post" action="/mypage/password-change">
                    <table class="register-table">
                        <tr>
                            <td>元パスワード</td>
                            <td>
                                <input type="password" name="password" value="@if($user->password != null){{$user->password}}@endif"/>
                            </td>
                            <td>パスワード変更</td>
                            <td>
                                <input type="password" name="passwordChange" value="@if($data != null){{$data['password_change']}}@endif"/>
                                @if(isset($error_message)&&$error_message['password_change'] != null)
                                    <span class="error_message">{{$error_message['password_change']}}</span>
                                @endif
                            </td>
                            <td>パスワード確認</td>
                            <td>
                                <input type="password"　name="passwordChange" value="@if($data != null){{$data['password_change_confirm']}}@endif" />
                                @if(isset($error_message)&&error_message['password_change_confirm' != null]))
                                <span class="error_message">{{$error_message['password_change_confirm']}}</span>
                                @endif
                            </td>
                            <td>
                                <button type="submit" onclick="return del();">確認</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
@endsection
