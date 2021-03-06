<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $data = $request->session()->get('order.address');
        $error_message = $request->session()->get('order.error_message');

        if ($data == null) {
            $data = [
                'postcode' => $user->postcode,
                'prefecture' => $user->prefecture,
                'city' => $user->city,
                'address' => $user->address,
                'tel' => $user->tel,
                'name' => $user->name,
            ];
        }

        if ($error_message == null) {
            $error_message = [
                'postcode' => null,
                'prefecture' => null,
                'city' => null,
                'address' => null,
                'tel' => null,
                'name' => null,
            ];
        }

        $request->session()->forget('order.address');
        $request->session()->forget('order.error_message');

        return view('order.index', [
            'data' => $data,
            'error_message' => $error_message
        ]);
    }

    public function order(Request $request)
    {
        $postcode = $request->post('postcode');
        $prefecture = $request->post('prefecture');
        $city = $request->post('city');
        $address = $request->post('address');
        $tel = $request->post('tel');
        $name = $request->post('name');

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
            $error_message['name']  = '???????????????';
            $has_error = true;
        }

        if ($postcode == "") {
            $error_message['postcode']  = '???????????????';
            $has_error = true;
        }

        if ($prefecture == "") {
            $error_message['prefecture']  = '???????????????????????????????????????';
            $has_error = true;
        }

        if ($city == "") {
            $error_message['city']  = '???????????????????????????????????????';
            $has_error = true;
        }

        if ($address == "") {
            $error_message['address']  = '?????????????????????????????????';
            $has_error = true;
        }

        if ($tel == "") {
            $error_message['tel']  = '???????????????????????????????????????';
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

    public function payment(Request $request)
    {
        if ($request->method() === 'POST') {
            // ????????????
            $card_no = $request->post('card_no');
            $expire_month = $request->post('expire-month');
            $expire_year = $request->post('expire-year');
            $cvc = $request->post('cvc');
            // ???????????????????????????????????????
            // ??????????????????????????????????????????????????? ???????????? / ???????????????
            // ???????????????
            $payment_success = true;

            // ??????????????????
            if (!$payment_success) {
                // ????????????
                $request->session()->flash('payment.error_message', true);

                return redirect('/payment');
            }

            // ?????????????????????????????????
            $address = $request->session()->get('order.address');
            $request->session()->forget('order.address');

            $order = new Order();
            $order->user_id = Auth::id();
            $order->name = $address['name'];
            $order->postcode = $address['postcode'];
            $order->prefecture = $address['prefecture'];
            $order->city = $address['city'];
            $order->address = $address['address'];
            $order->tel = $address['tel'];
            $order->status = 1;
            $order->save();

            $cart_bentos = Cart::where('user_id', Auth::id())->get();
            foreach ($cart_bentos as $cart) {
                $bento = Bento::find($cart->bento_id);

                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->bento_id = $cart->bento_id;
                $order_detail->bento_name = $bento->bento_name;
                $order_detail->price = $bento->price;
                $order_detail->bento_code = $bento->bento_code;
                $order_detail->description = $bento->description;
                $order_detail->guarantee_period = $bento->guarantee_period;
                $order_detail->quantity = $cart->quantity;
                $order_detail->save();

                // ?????????????????????
                $bento->stock = $bento->stock - $order_detail->quantity;
                $bento->save();

                // ???????????????
                $cart->delete();
            }

            return redirect('/order/complete');
        }

        $payment_failed = $request->session()->has('payment.error_message');

        return view('order.payment', ['payment_failed' => $payment_failed]);
    }

    public function complete(Request $request)
    {
        return view('order.complete');
    }

    public function cart(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        $bento_list = [];
        $total_quantity = 0;
        $total_price = 0;
        foreach ($carts as $cart) {
            $bento_id = $cart->bento_id;
            $quantity = $cart->quantity;

            $bento = Bento::find($bento_id);
            $bento->quantity = $quantity;

            $bento_list[] = $bento;

            $total_quantity += $quantity;
            $total_price += $bento->price * $quantity;
        }

        return view('order.cart',[
            'bentos' =>$bento_list,
            'total_quantity' => $total_quantity,
            'total_price'=>$total_price,
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

        return redirect(route('top'));
    }

    public function cartChangeQuantity(Request $request)
    {


        // Ajax
        // ????????????ID
        // ????????????ID????????????????????????????????????
        // ?????????????????????????????????
        // ???????????????1
        // ????????????????????????????????????
        $click = $request->post('click');
        $bento_id = $request->post('bento_id');
        $user_id = Auth::id();

        $bento_cart = Cart::where('user_id', $user_id)
            ->where('bento_id', $bento_id)
            ->first();

        $old_quantity = $bento_cart->quantity;



        if ($click === '+') {
            $bento_cart->quantity = $old_quantity + 1;
            $bento_cart ->save();
        }
        elseif ($click === '-') {
            if ($old_quantity === 1) {
                $bento_cart->delete();
            } else {
                $bento_cart->quantity = $old_quantity - 1;
                $bento_cart ->save();
            }
        }
        elseif ($click === 'cancel'){
            $bento_cart->delete();
        }

            return response()->json(['result' => 'success']);
    }

    public function history(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('order.history', [
            'orders' => $orders
        ]);
    }
}
