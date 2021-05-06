@extends('/layout')
@section('title','弁当編集')
@section('content')
<h1>弁当編集</h1>
<button type="button" ><a href="/bento-manage">戻る</a></button><br><br>
<p style="color:red;">@error('bento_code'){{$message}}@enderror()</p>

<form action="/bento-update-success" method="post">
<table  style="border:1px solid black;border-collapse: collapse;">
    <tr>
    <tr>
        <td style="border:1px solid black;width:100px">ID:</td>
        <td style="border:1px solid black;width:250px">{{$bento_id}}</td>
        <td style="border:1px solid black;width:100px">商品名:</td>
        <td style="border:1px solid black;width:250px"><input type="text" placeholder="{{$bento_name}}" name="bento_name"></td>
    </tr>
    <tr>
        <td style="border:1px solid black;width:100px">価格：</td>
        <td style="border:1px solid black;width:250px"><input type="number" placeholder="{{$price}}" name="price"></td>
        <td style="border:1px solid black;width:100px">商品コード：</td>
        <td style="border:1px solid black;width:250px"><input type="text" placeholder="{{$bento_code}}" name="bento_code"></td>
    </tr>
    <tr>
        <td style="border:1px solid black;width:100px">商品説明：</td>
        <td style="border:1px solid black;width:250px"><input type="text" placeholder="{{$description}}" name="description"></td>
        <td style="border:1px solid black;width:100px">賞味期限：</td>
        <td style="border:1px solid black;width:250px"><input type="datetime-local" placeholder="{{$guarantee_period}}" name="guarantee_period"></td>
    </tr>
    <tr>
        <td style="border:1px solid black;width:100px">在庫数：</td>
        <td style="border:1px solid black;width:250px"><input type="number" placeholder="{{$stock}}" name="stock"></td>
        <td style="border:1px solid black;width:100px">登録者：</td>
        <td style="border:1px solid black;width:250px">
            <select name="user_id">
                @foreach($user_ids as $id)
                    <option value="{{$id}}">{{$id}}</option>
                @endforeach
            </select>
        </td>
    </tr>
    </tr>
</table><br><br>
    <input type="hidden" name="id" value="{{$bento_id}}">
    <input type="submit" value="編集">
</form>

@endsection
