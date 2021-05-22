@extends('layout')

@section('title', '新規登録')

@section('content')
<main class="center">
    <h1>新規登録</h1>
    <div>
        <form method="post" action="{{ route('post_register-user') }}" enctype="multipart/form-data">
            <table class="register-table">
                <tr>
                    <td>メールアドレス</td>
                    <td>
                        <!--插入正确数据-->
                        <input type="text" name="email" value="{{ old('email') }}" />
                        <!--报错-->
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td>
                        <input type="password" name="password" value="{{ old('password') }}" />
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>パスワード確認</td>
                    <td>
                        <input type="password" name="password_confirm" value="{{ old('password_confirm') }}" />
                        @error('password_confirm')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td>
                        <input type="text" name="name" value="{{ old('name') }}" />
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
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
                        <input type="text" name="postcode" value="{{ old('postcode') }}" />
                        @error('postcode')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td>
                        <input type="text" name="prefecture" value="{{ old('prefecture') }}" />
                        @error('prefecture')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>市区町村</td>
                    <td>
                        <input type="text" name="city" value="{{ old('city') }}" />
                        @error('city')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td>
                        <input type="text" name="address" value="{{ old('address') }}" />
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>
                        <input type="text" name="tel" value="{{ old('tel') }}" />
                        @error('tel')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
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
