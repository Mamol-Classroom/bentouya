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
        $user_id = Auth::id();
        $bento_id = $request->post('bento_id');
        $cart_bento = Cart::where('bento_id',$bento_id)->where('user_id',$user_id)->first();
        $old_quantity = $cart_bento->quantity;
        $add_quantity = $old_quantity + 1 ;
        $minus_quantity = $old_quantity - 1 ;
        $cart_bento -> quantity = $add_quantity ;
        $cart_bento -> quantity = $minus_quantity ;
        $cart_bento -> save();

        return response()->json(['result' => 'success']);
    }
}
