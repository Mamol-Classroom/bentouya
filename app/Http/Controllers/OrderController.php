<?php

namespace App\Http\Controllers;
use App\Models\Bento;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function index(Request $request)
    {
        $user=Auth::user();
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

        return view('order.index',[
            'data'=>$data,
            'error_message'=>$error_message,
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
            $error_message['name']  = '名前を入力してください';
            $has_error = true;
        }

        if ($postcode == "") {
            $error_message['postcode']  = '郵便番号を入力してください';
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

    public function payment(Request $request)
    {
        if($request->method() === 'POST'){
            //处理支付
            $card_num = $request->post('card_num');
            $month= $request->post('expire-month');
            $year = $request->post('expire-year');
            $cvc = $request->post('cvc');
            //将上述信息传送给信用卡公司
            //等待支付处理结果，获得反馈信息（返回值 支付成功/支付失败）
            //（加数据）
            $payment_success = true;
            //生成订单数据

            if(!$payment_success){
                //支付失败
                $request->session()->flash('payment.error_message',true);
                return redirect('/payment');
            }
            //支付成功，生成订单数据
            $address = $request->session()->get('order.address');
           // $request->session()->forget('order.address');

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


            $cart_bentos = Cart::where('user_id',Auth::id())->get();




                $order_detail_list= [];

                foreach ($cart_bentos as $cart){
                    $bento = Bento::find($cart->bento_id);
                    $bento_img = $bento->get_bento_image_url();

                    $order_detail =new OrderDetail();
                    $order_detail->order_id = $order->id;
                    $order_detail->bento_id = $cart->bento_id;
                    $order_detail->bento_name = $bento->bento_name;
                    $order_detail->price = $bento->price;
                    $order_detail->bento_code = $bento->bento_code;
                    $order_detail->description = $bento->description;
                    $order_detail->guarantee_period = $bento->guarantee_period;
                    $order_detail->quantity = $cart->quantity;
                    $order_detail->save();

                    $order_detail-> bento_img = $bento_img;
                    $order_detail_list[] = $order_detail;


                    //削减商品库存数量
                    $bento->stock = $bento->stock - $order_detail->quantity;
                    $bento->save();

                    //清空购物车
                    $cart->delete();
                }

            $request->session()->put('order.detail.list',$order_detail_list);
                return redirect('/order/complete');
        }

        $payment_failed =$request->session()->has('payment.error_message');

        return view('order.payment',['payment_failed' => $payment_failed]);
    }

    public function complete(Request $request)
    {

       $order_detail_list = $request->session()->get('order.detail.list');
        $data = $request->session()->get('order.address');

        $request->session()->forget('order.address');

        return view('order.complete',[

            'name' => $data['name'],
            'postcode' => $data['postcode'],
            'prefecture' => $data['prefecture'],
            'city' => $data['city'],
            'address' => $data['address'],
            'tel' => $data['tel'],

            'order_detail_list'=>$order_detail_list,
        ]);


    }


    public function cart(Request $request)
    {

        $carts = Cart::where('user_id',Auth::id())->get();
        $bento_list = [];
        $total_quantity = 0;
        $total_price = 0;
        foreach ($carts as $cart){
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



    public function addToCart(Request $request){

        //检测值是否收到
        //dump($request->post('bento_id'));
        //dump($request->post('quantity'));
        //exit;
        $user_id =Auth::id();
        $bento_id = $request->post('bento_id');
        $quantity = $request->post('quantity');

        $cart_bento = Cart::where('bento_id',$bento_id)->where('user_id',$user_id)->first();
        if ($cart_bento == null){
            $cart = new Cart();
            $cart ->user_id = $user_id;
            $cart ->bento_id = $bento_id;
            $cart ->quantity = $quantity;
            $cart ->save();
        }else{
            $cart_bento->quantity = $cart_bento->quantity + $quantity;
            $cart_bento ->save();
        }



        $request->session()->flash('add_cart_success',$bento_id);

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
//排序orderBy
        $orders = Order::where('user_id',Auth::id())->orderBy('created_at', 'desc')->get();



        return view('order.history',[

            'orders' => $orders
        ]);





    }









}
