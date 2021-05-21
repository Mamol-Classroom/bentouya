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

        if($data == null){
            $data = [
                'postcode' => $user->postcode,
                'prefecture' => $user->prefecture,
                'city' => $user->city,
                'address' => $user->address,
                'tel' => $user->tel,
                'name' => $user->name,
            ];
        }

        if($error_message == null){
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

        return view('order.index',[
            'data' => $data,
            'error_message' => $error_message,
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

        $label_name = [
            'postcode' => '郵便番号',
            'prefecture' => '都道府県',
            'city' => '市区町村',
            'address' => '住所',
            'tel' => '電話番号',
            'name' => '名前',
        ];

        foreach($data as $key => $value){
            if($value == ''){
                $error_message[$key] = $label_name[$key].'を入力してください';
                $has_error = true;
            }
        }
        if($has_error){
            $request->session()->put('order.error_message',$error_message);
            $request->session()->put('order.address',$data);

            return redirect('/order');
        }

        $request->session()->put('order.address',$data);  //将填写的数据代入支付页面

        return redirect('/payment');

    }

    public function payment(Request $request)
    {

        if(!$request->session()->has('order.address')){  //has:判定是否存在邮送信息，返回true或者false
            return redirect()->route('get_top');
        }

        if($request->method() === 'POST'){
            //处理支付
            $card_no = $request->post('card_no');  //key是payment.blade中的name
            $expire_month = $request->post('expire-month');
            $expire_year = $request->post('expire-year');
            $cvc = $request->post('cvc');
            // 将上述数据传送给信用卡公司
            // 等待支付处理完成，获得反馈（返回值 支付成功 / 支付失败）
            // （假数据）
            $payment_success = true;

            //生成订单数据
            if(!$payment_success){
                //支付失败
                $request->session()->flash('payment.error_message',true);  //闪存一次支付失败信息

                return redirect('/payment');  //将支付失败信息重定向到支付页面
            }

            //支付成功，生成订单数据
            $address = $request->session()->get('order.address');  //接收上边order页面传来的数据
            $request->session()->forget('order,address');

            //将支付成功的订单存入数据库
            $order = new Order();
            $order->user_id = Auth::id();
            $order->name = $address['name'];  //从上边get传过来的session里取值
            $order->postcode = $address['postcode'];
            $order->prefecture = $address['prefecture'];
            $order->city = $address['city'];
            $order->address = $address['address'];
            $order->tel = $address['tel'];
            $order->status = 1;  //1在数据库中的说明为：注文済み
            $order->save();

            //将支付成功的订单bento详细信息存入数据库
            $cart_bentos = Cart::where('user_id',Auth::id())->get();
            foreach ($cart_bentos as $cart){
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->bento_id = $cart->bento_id;

                $bento = Bento::find($cart->bento_id);  //Cart内没有详细的bento信息
                $order_detail->bento_name = $bento->bento_name;
                $order_detail->price = $bento->price;
                $order_detail->bento_code = $bento->bento_code;
                $order_detail->description = $bento->description;
                $order_detail->guarantee_period = $bento->guarantee_period;
                $order_detail->quantity = $cart->quantity;
                $order_detail->save();

                //削减商品在库数
                $bento->stock = $bento->stock - $order_detail->quantity;
                $bento->save();

                //清空购物车
                $cart->delete();  //直接硬删除
            }

            return redirect('/order/complete');

        }

        $payment_failed = $request->session()->has('payment.error_message');  //has:判定支付是否成功即可，不需要get保留私密数据

        return view('order.payment',['payment_failed' => $payment_failed]);
    }

    public function complete(Request $request)
    {
        return view('order.complete');
    }

    public function cart(Request $request)
    {
        $carts = Cart::where('user_id',Auth::id())->get();
        $bento_list = [];
        $total_quantity = 0;  //添加一个收藏bento总数
        $total_price = 0;

        foreach($carts as $cart){
            $bento_id = $cart->bento_id;
            $quantity = $cart->quantity;

            $bento = Bento::find($bento_id);  //将收藏bento信息全部调出，方便后续直接使用
            $bento->quantity = $quantity;

            $bento_list[] = $bento;
            $total_quantity += $quantity;  //添加一个收藏bento总数量
            $total_price += $bento->price * $quantity;  //计算总价
        }

        return view('order.cart',[
            'bentos' => $bento_list,
            'total_quantity' => $total_quantity,  //将新添加的总数量渲染模板
            'total_price' => $total_price,
        ]);
    }

    public function addToCart(Request $request)
    {
        $user_id = Auth::id();
        $bento_id = $request->post('bento_id');
        $quantity = $request->post('quantity');

        $cart_bento = Cart::where('bento_id',$bento_id)->where('user_id',$user_id)->first();
        if($cart_bento == null){             //判定如果该bento未收藏情况下直接添加
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->bento_id = $bento_id;
            $cart->quantity = $quantity;
            $cart->save();
        }else{                                //已被收藏则直接在原有数量上进行改动，而不是重新建立$cart
            $cart_bento->quantity = $cart_bento->quantity + $quantity;
            $cart_bento->save();
        }

        $request->session()->flash('add_cart_bento',$bento_id);  //TopController内接收
        $request->session()->flash('add_cart_quantity',$quantity);  //TopController内接收

        return redirect()->route('get_top');   //重定向到首页
    }
    public function cartChangeQuantity(Request $request)
    {
        //Ajax:
        //接收便当ID
        //通过便当ID去数据库查找该购物车信息
        //从数据库中取得当前数量
        //当前数量+1
        //将改变后的数量存入数据库

        $click = $request->post('click');  //将的cart.blade中的key传进来
        $bento_id = $request->post('bento_id');
        $user_id = Auth::id();

        $bento_cart = Cart::where('user_id',$user_id)
            ->where('bento_id',$bento_id)
            ->first();

        $old_quantity = $bento_cart->quantity;

        if($click === '+' ){
            $bento_cart->quantity = $old_quantity + 1;
            $bento_cart->save();

            return response()->json(['result' => 'add']);
        }

        elseif($click === '-' ){
            if($old_quantity === 1){   //已添加商品数量为1时，再减少1件则删除该收藏
                $bento_cart->delete();
            }else{
                $bento_cart->quantity = $old_quantity - 1;
                $bento_cart->save();
            }

            return response()->json(['result' => 'reduce']);
        }
        elseif($click === 'cancel'){
            $bento_cart->delete();
            return response()->json(['result' => 'delete']);
        }

            return response()->json();  //避免没有点击事件发生时报错
    }


}
