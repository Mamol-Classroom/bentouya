<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
Use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $data = $request->session()->get('data');
        if($data == ''){
            $data =[
                'email'=>$user->email,
                'name'=>$user->name,
                'postcode'=>$user->postcode,
                'prefecture'=>$user->prefecture,
                'city'=>$user->city,
                'address'=>$user->address,
                'tel'=>$user->tel,
            ];
        }
        return view('mypage.index', ['data' => $data]);
    }


    public function favourite(Request $request)
    {
        // ログインしているユーザーIDの取得
        $user_id = Auth::id();
        // favouritesテーブルから注目している弁当のIDリストの取得
        $bento_id_list = [];
        // ログインしているユーザーIDが注目したデーターの取得(Array)
        $favourites = Favourite::where('user_id', $user_id)->get();
        // $favouritesから弁当IDの取得して、$bento_id_listに追加
        foreach ($favourites as $favourite) {
            // 該当弁当IDの取得
            $bento_id = $favourite->bento_id;
            // 該当弁当IDを$bento_id_listの末に追加
            $bento_id_list[] = $bento_id;
        }

        // Bentosテーブルから、弁当のIDリストに基づいて弁当情報の取得
        $bentos = Bento::whereIn('id', $bento_id_list)->get();

        return view('mypage.favourite', [
            'bentos' => $bentos
        ]);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->session()->get('data');

        if($data == ''){
            $data =[
                'email'=>$user->email,
                'name'=>$user->name,
                'postcode'=>$user->postcode,
                'prefecture'=>$user->prefecture,
                'city'=>$user->city,
                'address'=>$user->address,
                'tel'=>$user->tel,
            ];
            return view('mypage.update', ['data' => $data]);
        }

        $error_message = [
            'email' => null,
            'postcode' => null,
            'prefecture' => null,
            'city' => null,
            'address' => null,
            'tel' => null,
            'name' => null,
        ];

        $data = [
            'email' => '',
            'postcode' => '',
            'prefecture' => '',
            'city' => '',
            'address' => '',
            'tel' => '',
            'name' => '',
        ];

        return view('mypage.update', [
            'data' => $data,
            'error_message' => $error_message
        ]);
    }

    public function orderlist(request $request)
    {
        $order = Order::where('user_id', Auth::id())->first();
        $order_id[] = $order->wherein('id',[]);
        $order_details = OrderDetail::where('order_id',$order_id)->get();
        $order_detail = [];
        $total_price = 0;
        $total_quantity = 0;
        foreach ($order_details() as $order_detail) {
            $quantity = $order_details->quantity;
            $order_detail[] = $order_detail;
            $total_quantity += $quantity;
            $total_price += $order_detail->price * $quantity;
        }
        return view('mypage.order_list', [
            'order_detail' => $order_detail,
            'order_id' => $order_id,
            'total_price' => $total_price,
            'total_quantity' => $total_quantity,
        ]);

    }

    public function password_change(Request $request)
    {

    }

}
