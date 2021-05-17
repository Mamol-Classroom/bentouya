<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Cart;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::where('user_id',Auth::id())->get();
        $bento_list = [];
        $total_price = 0;
        foreach($carts as $cart){
            $bento_id = $cart->bento_id;
            $quantity = $cart->quantity;

            $bento = Bento::find($bento_id);  //将收藏bento信息全部调出，方便后续直接使用
            $bento->quantity = $quantity;

            $bento_list[] = $bento;
            $total_price += $bento->price * $quantity;  //计算总价
        }

        return view('order.cart',[
            'bentos' => $bento_list,
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

        return redirect('/');   //重定向到首页
    }
}
