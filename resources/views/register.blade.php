@extends('layout')

@section('title', '新規登録')

@section('content')
<main class="center">
    <h1>新規登録</h1>
    <div>
        <form method="post" action="/register-user" enctype="multipart/form-data">
            <table class="register-table">
                <tr>
                    <td>メールアドレス</td>
                    <td>
                        <!--插入正确数据-->
                        <input type="text" name="email" value="@if($data != null){{ $data['email'] }}@endif" />
                        <!--报错-->
                        @if(isset($error_message) && $error_message['email'] != null)
                            <span class="error-message">{{ $error_message['email'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
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
                    <td>名前</td>
                    <td>
                        <input type="text" name="name" value="{{ $data['name'] }}" />
                        @if(isset($error_message) && $error_message['name'] != null)
                            <span class="error-message">{{ $error_message['name'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>ユーザー画像</td>
                    <td>
                        <input type="file" name="headPortrait_url" />
                    </td>
                </tr>
                <tr>
                    <td>郵便番号</td>
                    <td>
                        <input type="text" name="postcode" value="{{ $data['postcode'] }}" />
                        @if(isset($error_message) && $error_message['postcode'] != null)
                            <span class="error-message">{{ $error_message['postcode'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td>
                        <input type="text" name="prefecture" value="{{ $data['prefecture'] }}" />
                        @if(isset($error_message) && $error_message['prefecture'] != null)
                            <span class="error-message">{{ $error_message['prefecture'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>市区町村</td>
                    <td>
                        <input type="text" name="city" value="{{ $data['city'] }}" />
                        @if(isset($error_message) && $error_message['city'] != null)
                            <span class="error-message">{{ $error_message['city'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td>
                        <input type="text" name="address" value="{{ $data['address'] }}" />
                        @if(isset($error_message) && $error_message['address'] != null)
                            <span class="error-message">{{ $error_message['address'] }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>
                        <input type="text" name="tel" value="{{ $data['tel'] }}" />
                        @if(isset($error_message) && $error_message['tel'] != null)
                            <span class="error-message">{{ $error_message['tel'] }}</span>
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
</main>
@endsection
