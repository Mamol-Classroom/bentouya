@extends('layout')

@section('title','弁当登録')

@section('content')

    <main class="center">
        <h1>弁当登録</h1>

        <div>
            <form method="post" action="/bento-register-user">
                <table class="register-table">
                    <tr>
                        <td>弁当名</td>
                        <td>
                            <input type="text" name="bento_name" value="@if(isset($bento_data)){{ $bento_data['bento_name'] }}@endif" />
                            @if(isset($bento_error_message) && $bento_error_message['bento_name'] != null)
                                <span class="error-message">{{ $bento_error_message['bento_name'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>価格</td>
                        <td>
                            <input type="text" name="price" value="{{ $bento_data['price'] }}" />
                            @if(isset($bento_error_message) && $bento_error_message['price'] != null)
                                <span class="error-message">{{ $bento_error_message['price'] }}</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>商品コード</td>
                        <td>
                            <input type="text" name="bento_code" value="{{ $bento_data['bento_code'] }}" />
                            @if(isset($bento_error_message) && $bento_error_message['bento_code'] != null)
                                <span class="error-message">{{ $bento_error_message['bento_code'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>商品説明</td>
                        <td>
                            <input type="text" name="description" value="{{ $bento_data['description'] }}" />
                        </td>
                    </tr>
                    <tr>
                        <td>賞味期限</td>
                        <td>
                            <input type="text" name="guarantee_period" value="{{ $bento_data['guarantee_period'] }}" />
                            @if(isset($bento_error_message) && $bento_error_message['guarantee_period'] != null)
                                <span class="error-message">{{ $bento_error_message['guarantee_period'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>在庫数</td>
                        <td>
                            <input type="text" name="stock" value="{{ $bento_data['stock'] }}" />
                            @if(isset($bento_error_message) && $bento_error_message['stock'] != null)
                                <span class="error-message">{{ $bento_error_message['stock'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>ユーザーID</td>
                        <td>
                            <input type="text" name="user_id" value="{{ $bento_data['user_id'] }}" />
                            @if(isset($bento_error_message) && $bento_error_message['user_id'] != null)
                                <span class="error-message">{{ $bento_error_message['user_id'] }}</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">登録</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
@endsection
