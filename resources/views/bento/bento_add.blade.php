@extends('/layout')
@section('title','弁当登録')
@section('content')
    <h1>弁当登録ページ</h1>


    <form method="POST" action="/bento-add-success">
        <table>
            <tr>
                <td>商品名：</td>
                <td><input type="text" name="bento_name"></td>
                <td><p style="color:red">@error('bento_name'){{$message}}@enderror()</p></td>
            </tr>
            <tr>
                <td>価格：</td>
                <td><input type="number" name="price"></td>
                <td><p style="color:red">@error('price'){{$message}}@enderror()</p></td>
            </tr>
            {{--
            <tr>
                <td>商品コード：</td>
                <td><input type="text" name="bento_code"></td>
                <td><p style="color:red">@error('bento_code'){{$message}}@enderror()</p></td>
            </tr>
            --}}
            <tr>
                <td>賞味期限：</td>
                <td><input type="date" name="guarantee_period"></td>
                <td><p style="color:red">@error('guarantee_period'){{$message}}@enderror()</p></td>
            </tr>
            <tr>
                <td>在庫数：</td>
                <td><input type="number" name="stock"></td>
                <td><p style="color:red">@error('stock'){{$message}}@enderror()</p></td>
            </tr>
            {{--
            <tr>
                <td>登録者：</td>
                <td>
                    <select name="user_id">
                        @foreach($user_ids as $id)
                            <option value="{{$id}}">{{$id}}</option>
                        @endforeach
                    </select>
                </td>
                <td><p style="color:red">@error('user_id'){{$message}}@enderror()</p></td>
            </tr>
            --}}
            <tr>
                <td>商品説明：</td>
                <td><input type="text" name="description"></td>
                <td><p style="color:red">@error('description'){{$message}}@enderror()</p></td>
            </tr>
            <tr>
                <td></td>
                <td> <input type="submit" value="登録"></td>
            </tr>








        </table>
    </form>

    <a href="/bento-manage">戻る</a>


@endsection
