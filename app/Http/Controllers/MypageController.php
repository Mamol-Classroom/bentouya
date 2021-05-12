<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        // プロフィール

        $data = [
            'email' => '',
            'postcode' => '',
            'prefecture' => '',
            'city' => '',
            'address' => '',
            'tel' => '',
            'name' => '',
        ];

        $user = Auth::user();
        $user_id = Auth::id();

        $data = $request->session()->get('data');

        $request->session()->forget('data');

        if ($data == '') {
            $data = [
                'email' => $user->email,
                'name' => $user->name,
                'postcode' => $user->postcode,
                'prefecture' => $user->prefecture,
                'city' => $user->city,
                'address' => $user->address,
                'tel' => $user->tel
            ];

            $request->session()->put('data', $data);
        }

        if ($request->method() == 'POST') {
            $email = $request->post('email');
            $name = $request->post('name');
            $postcode = $request->post('postcode');
            $prefecture = $request->post('prefecture');
            $city = $request->post('city');
            $address = $request->post('address');
            $tel = $request->post('tel');

            $data = [
                'email' => $email,
                'name' => $name,
                'postcode' => $postcode,
                'prefecture' => $prefecture,
                'city' => $city,
                'address' => $address,
                'tel' => $tel
            ];

            //更改数据存入数据库
            $user->email = $data['email'];
            $user->name = $data->name;
            $user->postcode = $data->postcode;
            $user->prefecture = $data->prefecture;
            $user->city = $data->city;
            $user->address = $data->address;
            $user->tel = $data->tel;
            $user->save();

            return redirect('/mypage');
        }

        return view('mypage.index', [
            'data' => $data,
        ]);
    }
}




