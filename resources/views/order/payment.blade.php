@extends('layout')

@section('title','お支払い')

@section('content')
    <main class="center">
        <h1>お支払い</h1>
        <div>
            @if($payment_failed)
                <p class="error-message">支払い失敗</p>
            @endif
            <form method="post" action="/payment">
                <table class="register-table">
                    <tr>
                        <td>カード番号</td>
                        <td>
                            <input type="text" name="card_no" value="" placeholder="カード番号"/>
                        </td>
                    </tr>
                    <tr>
                        <td>有効期限</td>
                        <td>
                            <input type="text" name="expire-month" value="" placeholder="月"/>
                            -
                            <input type="text" name="expire-year" value="" placeholder="年"/>
                        </td>
                    </tr>
                    <tr>
                        <td>CVC</td>
                        <td>
                            <input type="text" name="cvc" value="" placeholder="CVC"/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">注文確定</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
@endsection
