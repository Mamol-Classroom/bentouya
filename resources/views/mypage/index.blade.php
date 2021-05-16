@extends('mypage.layout')

@section('title', 'マイページ')

@section('mypage-content')
        <div class="subview">
            <h1>プロフィール</h1>
            <div>
                <form method="post" action="/mypage">
                    <table class="register-table">
                        <tr>
                            <td>メールアドレス</td>
                            <td>
                                <input type="text" name="email" value="{{ $data['email'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>名前</td>
                            <td>
                                <input type="text" name="name" value="{{ $data['name'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>郵便番号</td>
                            <td>
                                <input type="text" name="postcode" value="{{ $data['postcode'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>都道府県</td>
                            <td>
                                <input type="text" name="prefecture" value="{{ $data['prefecture'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>市区町村</td>
                            <td>
                                <input type="text" name="city" value="{{ $data['city'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>住所</td>
                            <td>
                                <input type="text" name="address" value="{{ $data['address'] }}" />
                            </td>
                        </tr>
                        <tr>
                            <td>電話番号</td>
                            <td>
                                <input type="text" name="tel" value="{{ $data['tel'] }}" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
@endsection

