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
        $carts = Cart::where('user_id', Auth::id())->get();
        $bento_list = [];
        $total_price = 0;
        foreach ($carts as $cart) {
            $bento_id = $cart->bento_id;
            $quantity = $cart->quantity;

            $bento = Bento::find($bento_id);
            $bento->quantity = $quantity;

            $bento_list[] = $bento;
            $total_price += $bento->price * $quantity;
        }

        return view('order.cart', [
            'bentos' => $bento_list,
            'total_price' => $total_price
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
}
