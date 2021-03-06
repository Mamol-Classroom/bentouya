@extends('layout')

@section('title', '配送先入力')

@section('content')
    <main class="center">
        <h1>配送先入力</h1>
        <div>
            <form method="post" action="/order">
                <table class="register-table">
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
