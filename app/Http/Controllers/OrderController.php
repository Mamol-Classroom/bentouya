<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
class OrderController extends Controller
{
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



        $request->session()->flash('add_cart_bento_id', $bento_id);

        return redirect('/');
    }
}
