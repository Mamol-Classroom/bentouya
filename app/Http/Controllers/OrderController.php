<?php


namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $data = $request->session()->get('order.adderess');
        $error_message = $request->session()->get('order.error_message');

        $request->session()->forget('order.adderess');
        $request->session()->forget('order.error_message');

        if($data == null)
        {
            $data =[
                'postcode' => $user->postcode,
                'prefecture' => $user->prefecture,
                'city' => $user->city,
                'address' => $user->address,
                'tel' => $user->tel,
                'name' => $user->name,
            ];
        }
        if($error_message == null)
        {
            $error_message =[
                'postcode' => '',
                'prefecture' => '',
                'city' => '',
                'address' => '',
                'tel' => '',
                'name' => '',
            ];
        }

        return view ('order.index',
            ['data' => $data,
             'error_message' => $error_message
            ] );
    }

    public function order(request $request)
    {
        $postcode = $request -> post('postcode');
        $prefecture = $request -> post('prefecture');
        $city = $request -> post('city');
        $address = $request -> post('address');
        $tel = $request -> post('tel');
        $name = $request -> post('name');

        $data = [
            'postcode' => $postcode,
            'prefecture' => $prefecture,
            'city' => $city,
            'address' => $address,
            'tel' => $tel,
            'name' => $name,
        ];

        $has_error = false;
        $error_message = [
            'postcode' => null,
            'prefecture' => null,
            'city' => null,
            'address' => null,
            'tel' => null,
            'name' => null,
        ];

        if ($name == "") {
            $error_message['name']  = '请输入姓名';
            $has_error = true;
        }

        if ($postcode == "") {
            $error_message['postcode']  = '请输入邮编';
            $has_error = true;
        }

        if ($prefecture == "") {
            $error_message['prefecture']  = '都道府県を入力してください';
            $has_error = true;
        }

        if ($city == "") {
            $error_message['city']  = '市区町村を入力してください';
            $has_error = true;
        }

        if ($address == "") {
            $error_message['address']  = '住所を入力してください';
            $has_error = true;
        }

        if ($tel == "") {
            $error_message['tel']  = '電話番号を入力してください';
            $has_error = true;
        }

        if ($has_error) {
            $request->session()->put('order.error_message', $error_message);
            $request->session()->put('order.address', $data);

            return redirect('/order');
        }

        $request->session()->put('order.address', $data);

        return redirect('/payment');
    }

    public function payment(request $request)
    {
        return view('payment');
    }

    public function cart(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        $bento_list = [];
        $total_price = 0;
        $total_quantity = 0;
        foreach ($carts as $cart) {
            $bento_id = $cart->bento_id;
            $quantity = $cart->quantity;

            $bento = Bento::find($bento_id);
            $bento->quantity = $quantity;

            $bento_list[] = $bento;
            $total_quantity += $quantity;
            $total_price += $bento->price * $quantity;
        }

        return view('order.cart', [
            'bentos' => $bento_list,
            'total_price' => $total_price,
            'total_quantity' => $total_quantity,
        ]);
    }

    public function addToCart(Request $request)
    {
        $user_id = Auth::id();
        $bento_id = $request->post('bento_id');
        $quantity = $request->post('quantity');

        $cart_bento = Cart::where('bento_id', $bento_id)->where('user_id', $user_id)->first();
        if ($cart_bento == null) {
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->bento_id = $bento_id;
            $cart->quantity = $quantity;
            $cart->save();
        } else {
            $cart_bento->quantity = $cart_bento->quantity + $quantity;
            $cart_bento->save();
        }

        $request->session()->flash('add_cart_bento', $bento_id);

        return redirect('/');
    }
    public function cartChangeQuantity(Request $request)
    {
        // Ajax

        // 接收便当ID
        // 通过便当ID去数据库查找该购物车信息
        // 从数据库中取得当前数量
        // 当前数量加1
        // 将改变后的数量存入数据库
        $user_id = Auth::id();
        $bento_id = $request->post('bento_id');
        $click = $request -> post('click');
        $cart_bento = Cart::where('bento_id',$bento_id)->where('user_id',$user_id)->first();
        $old_quantity = $cart_bento->quantity;
        if ($click === '+') {
            $cart_bento->quantity = $old_quantity + 1;
        }
        elseif($click === '-') {
            $cart_bento->quantity = $old_quantity - 1;
        }
        $cart_bento -> save();

        return response()->json(['result' => 'success']);

    }
}
