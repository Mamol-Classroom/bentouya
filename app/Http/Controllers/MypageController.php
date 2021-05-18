<?php

namespace App\Http\Controllers;

use App\Models\BentosImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Bento;
use App\Models\Favourite;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();

        $error_message = $request->session()->get('error_message');
        $data = $request->session()->get('data');

        $request->session()->forget('error_message');
        $request->session()->forget('data');
        // プロフィール
        if ($error_message == null) {
            $error_message = [
                'email' => null,
                'postcode' => null,
                'prefecture' => null,
                'city' => null,
                'address' => null,
                'tel' => null,
                'name' => null,
            ];
        }

        if ($data == null) {
            $data = [
                'email' => $user -> email,
                'postcode' => $user -> postcode,
                'prefecture' => $user -> prefecture,
                'city' => $user -> city,
                'address' => $user -> address,
                'tel' => $user -> tel,
                'name' => $user ->name,
            ];
        }

        $has_error = false;

        if($request -> method() ==='POST'){
            $email = $request -> post('email');
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
                'tel' => $tel,

            ];


            $label_name = [
                'email' => "メールアドレス",
                'name' => "名前",
                'postcode' => "郵便番号",
                'prefecture' => "都道府県",
                'city' => "市区町村",
                'address' => "住所",
                'tel' => "電話番号",

            ];

            foreach ($data as $key => $value) {
                if ($value == '') {
                    $error_message[$key] = $label_name[$key] . 'を入力してください';
                    $has_error = true;
                }
            }

            if ($has_error) {
                $request->session()->put('error_message', $error_message);
                $request->session()->put('data', $data);

                return redirect('/mypage');
            }


// 将输入的数据存入数据库
            $user->email = $email;
            $user->name = $name;
            $user->postcode = $postcode;
            $user->prefecture = $prefecture;
            $user->city = $city;
            $user->address = $address;
            $user->tel = $tel;
            $user->save();

            return redirect('/mypage');

        }

        return view('mypage.index', [
            'data' => $data,
            'error_message' => $error_message
        ]);
    }

    public function password_reset(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();

        $error_message = $request->session()->get('error_message');
        $password_info = $request->session()->get('password_reset');

        $request->session()->forget('error_message');
        $request->session()->forget('password_reset');

        if ($error_message == null){
            $error_message = ['password_reset' => null];
        }


        if ($password_info == null){
            $password_info = ['password_reset' => ''];
        }

        $has_error = false;

        if ($request -> method() === 'POST'){
            $password_reset = $request -> post('password_reset');

            $password_info = [
                'password_reset' => $password_reset
            ];

            if ($password_reset == ""){
                $error_message['password_reset'] = '新しいパスワードをご入力';
                $has_error = true;
            }

            if($has_error){
                $request -> session() ->put('error_message',$error_message);
                $request -> session() ->put('password_reset',$password_reset);

                return redirect('/mypage/password_reset');
            }

            $new_password =Hash::make($password_reset);
            $user -> password = $new_password;
            $user -> save();
            return redirect('/mypage/password_reset');
        }
        return view('/mypage/password_reset',[
            'password_reset' => $password_info,
            'error_message' => $error_message,
        ]);

    }

    public function favourite(Request $request)
    {
        $user_id = Auth::id();
        $bento_id_list = [];
        $favourites = Favourite::where('user_id',$user_id)->get();
        foreach ($favourites as $favourite){
            $bento_id = $favourite->bento_id;
            $bento_id_list[] = $bento_id;
        }

        $bentos= Bento::whereIn('id',$bento_id_list)->get();

        return view('mypage.favourite',['bentos' => $bentos]);
    }
}
