


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録ページ</title>
    <link rel="stylesheet" href="/css/register.css">

</head>

<body>
<h1>アカウント登録</h1>
<form method="post" action="/register-user">
    <table>
        <tr>
            <td>メールアドレス：</td>
            <td>
                <input type="text" name="email" value="{{old('email')}}">
                @if(isset($error_message) && $error_message['email']!=null)
                    <span class="error_message">{{$error_message['email']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>パスワード：</td>
            <td>
                <input type="password" name="password" value="{{old('password')}}">
                @if(isset($error_message) && $error_message['password']!=null)
                    <span class="error_message">{{$error_message['password']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>パスワード：</td>
            <td>
                <input type="password" name="password_confirm" value="{{old('password_confirm')}}">
                @if(isset($error_message) && $error_message['password_confirm']!=null)
                    <span class="error_message">{{$error_message['password_confirm']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>電話番号：</td>
            <td>
                <input type="text" name="telephone" value="{{old('telephone')}}">
                @if(isset($error_message) && $error_message['telephone']!=null)
                    <span class="error_message">{{$error_message['telephone']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>郵便番号：</td>
            <td>
                <input type="text" name="postcode" value="{{old('postcode')}}">
                @if(isset($error_message) && $error_message['postcode']!=null)
                    <span class="error_message">{{$error_message['postcode']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>都道府県：</td>
            <td>
                <input type="text" name="prefecture" value="{{old('prefecture')}}">
                @if(isset($error_message) && $error_message['prefecture']!=null)
                    <span class="error_message">{{$error_message['prefecture']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>市区町村：</td>
            <td>
                <input type="text" name="city" value="{{old('city')}}">
                @if(isset($error_message) && $error_message['city']!=null)
                    <span class="error_message">{{$error_message['city']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>住所：</td>
            <td>
                <input type="text" name="address" value="{{old('address')}}">
                @if(isset($error_message) && $error_message['address']!=null)
                    <span class="error_message">{{$error_message['address']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>名前：</td>
            <td>
                <input type="text" name="name" value="{{old('name')}}">
                @if(isset($error_message) && $error_message['name']!=null)
                    <span class="error_message">{{$error_message['name']}}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" >送信</button>
            </td>
        </tr>



    </table>

</form>




</body>


</html>
