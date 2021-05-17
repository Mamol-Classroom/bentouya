@extends('layout')

@section('title', '弁当登録')

@section('content')
    <main class="center">
        <h1>弁当登録</h1>
        <div>
            <form method="post" action="/bento/add" enctype="multipart/form-data">
                <!--enctype副本：ファイルアップロードをする場合input要素は<input type="file" />を使い、その親のform要素には以下のようにenctype="multipart/form-data"と書く必要があります-->
                <table class="register-table">
                    <tr>
                        <td>弁当名</td>
                        <td>
                            <input type="text" name="bento_name" value="{{ $data['bento_name'] }}" />
                            @if(isset($error_message) && $error_message['bento_name'] != null)
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
                            <textarea name="description" stylewidth: 500px; height: 200px;">{{ $data['description'] }}</textarea>
                            @if(isset($error_message) && $error_message['description'] != null)
                                <span class="error-message">{{ $error_message['description'] }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>弁当画像</td>
                        <td>
                            <input type="file" name="bento_img" />
                            <!--input的type="file"：ファイルアップロードをする場合input要素は<input type="file" />を使い、その親のform要素には以下のようにenctype="multipart/form-data"と書く必要があります-->
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
