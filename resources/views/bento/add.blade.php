@extends('layout')

@section('title', '弁当登録')

@section('content')
    <main class="center">
        <h1>弁当登録</h1>
        <div>
            <form method="post" action="/bento/add">
                <table class="register-table">
                    <tr>
                        <td>弁当名</td>
                        <td>
                            <input type="text" name="bento_name" value="{{ $data['bento_name'] }}" />
                            @if($error_message != null && $error_message['bento_name'] != null)
                                <span class="error-message">{{ $error_message['bento_name'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>価格</td>
                        <td>
                            <input type="number" name="price" value="{{ $data['price'] }}" />
                            @if(isset($error_message) && $error_message['price'] != null)
                                <span class="error-message">{{ $error_message['price'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>説明</td>
                        <td>
                            <textarea name="description" style="width: 500px; height: 200px;">{{ $data['description'] }}</textarea>
                            @if(isset($error_message) && $error_message['description'] != null)
                                <span class="error-message">{{ $error_message['description'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>賞味期限</td>
                        <td>
                            <input type="date" name="guarantee_period" value="{{ $data['guarantee_period'] }}" />
                            @if(isset($error_message) && $error_message['guarantee_period'] != null)
                                <span class="error-message">{{ $error_message['guarantee_period'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>在庫数</td>
                        <td>
                            <input type="number" name="stock" value="{{ $data['stock'] }}" min="0" />
                            @if(isset($error_message) && $error_message['stock'] != null)
                                <span class="error-message">{{ $error_message['stock'] }}</span>
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

