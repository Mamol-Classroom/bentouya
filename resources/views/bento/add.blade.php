@extends('layout')

@section('title', '弁当登録')

@section('content')
    <main class="center">
        <h1>弁当登録</h1>
        <div>
            {{--
            設定enctype為multipart/form-data值後，不對字元編碼，則資料通過二進位制的形式傳送到伺服器端，
            這時如果用request是無法直接獲取到相應表單的值的，而應該通過stream流物件，將傳到伺服器端的二進位制資料解碼，從而讀取資料。
            如果要上傳檔案的話，是一定要將encotype設定為multipart/form-data的。
            --}}
            <form method="post" action="/bento/add" enctype="multipart/form-data">
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
                        <td>画像</td>
                        <td>
                            <input type="file" name="bento_img" />
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

