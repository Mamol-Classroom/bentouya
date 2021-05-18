<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TopController extends Controller
{

    public function top(Request $request)
    {
        $word = $request->query('word');
        $price_l = $request->query('price_l');
        $price_h = $request->query('price_h');

        $bento_query = Bento::query();

        if ($word != null) {
            $bento_query->where('bento_name', 'like', '%'.$word.'%');
        }

        if ($price_l != null) {
            $bento_query->where('price', '>=', $price_l);
        }

        if ($price_h != null) {
            $bento_query->where('price', '<=', $price_h);
        }

        $bentos = $bento_query->paginate(4);
        //$bentos = $bento_query->get();

        $add_to_cart_bento_id = $request->session()->get('add_cart_bento_id');
        if ($add_to_cart_bento_id != null) {
            $add_to_cart_bento = Bento::find($add_to_cart_bento_id);
        }else {
            $add_to_cart_bento = '';
        }

        return view('top', [
            'bentos' => $bentos,
            'word' => $word,
            'price_l' => $price_l,
            'price_h' => $price_h,
            'add_to_cart_bento' => $add_to_cart_bento
        ]);
    }

    public function register(Request $request)
    {
        $error_message = $request->session()->get('error_message');
        $data = $request->session()->get('data');

        if ($error_message == null) {
            $error_message = [
                'email' => null,
                'password' => null,
                'password_confirm' => null,
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
                'email' => '',
                'password' => '',
                'password_confirm' => '',
                'postcode' => '',
                'prefecture' => '',
                'city' => '',
                'address' => '',
                'tel' => '',
                'name' => '',
            ];
        }

        return view('register', [
            'error_message' => $error_message,
            'data' => $data
        ]);
    }

    public function registerUser(Request $request,User $user)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $password_confirm = $request->post('password_confirm');
        $postcode = $request->post('postcode');
        $prefecture = $request->post('prefecture');
        $city = $request->post('city');
        $address = $request->post('address');
        $tel = $request->post('tel');
        $name = $request->post('name');
        $originalImg = $request->file('user_image');
        $data = [
            'email' => $email,
            'password' => $password,
            'password_confirm' => $password_confirm,
            'postcode' => $postcode,
            'prefecture' => $prefecture,
            'city' => $city,
            'address' => $address,
            'tel' => $tel,
            'name' => $name,
        ];

        $has_error = false;
        $error_message = [
            'email' => null,
            'password' => null,
            'password_confirm' => null,
            'postcode' => null,
            'prefecture' => null,
            'city' => null,
            'address' => null,
            'tel' => null,
            'name' => null,
        ];
        if ($email == "") {
            $error_message['email']  = '请输入邮箱';
            $has_error = true;
        }

        if ($password == "") {
            $error_message['password']  = '请输入密码';
            $has_error = true;
        }

        if ($password != $password_confirm) {
            $error_message['password_confirm']  = '两次输入的密码不一致';
            $has_error = true;
        }

        if ($name == "") {
            $error_message['name']  = '请输入姓名';
            $has_error = true;
        }

        if ($postcode == "") {
            $error_message['postcode']  = '请输入邮编';
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
            $request->session()->put('error_message', $error_message);
            $request->session()->put('data', $data);

            return redirect('/register');
        }







            // 将输入的数据存入数据库
        $user = new User();
        $user->email = $email;
        $hashed_password = Hash::make($password);
        $user->password = $hashed_password;
        $user->name = $name;
        $user->postcode = $postcode;
        $user->prefecture = $prefecture;
        $user->city = $city;
        $user->address = $address;
        $user->tel = $tel;
    if($request->hasFile('user_image')){
        if($originalImg->isValid()) {
            $filePath = $originalImg->store('public');
            $user->user_image = str_replace('public/', '', $filePath);}
    }
        $user->save();

        $request->session()->flash('registed_user', $user);

        return redirect('/register-success');
    }

    public function registerSuccess(Request $request)
    {
        $user = $request->session()->get('registed_user');
        $request->session()->keep('registed_user');

        return view('register_success', [
            'email' => $user->email,
            'name' => $user->name,
            'postcode' => $user->postcode,
            'prefecture' => $user->prefecture,
            'city' => $user->city,
            'address' => $user->address,
            'tel' => $user->tel,
            'originalImg' => $user->user_image
        ]);
    }

    public function login(Request $request)
    {
        if ($request->method() == 'POST') {
            $email = $request->post('email');
            $password = $request->post('password');

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // ログイン成功
                return redirect('/');
            } else {
                // ログイン失敗
                $request->session()->put('login_failed', true);

                return redirect('/login');
            }

            /**
            $user = User::where('email', $email)->first();
            if ($password == $user->password) {
                // ログイン成功
                return redirect('/');
            } else {
                // ログイン失敗
                $request->session()->put('login_failed', true);

                return redirect('/login');
            }
             */
        }

        $login_failed = $request->session()->get('login_failed');
        $request->session()->forget('login_failed');

        return view('login', [
            'login_failed' => $login_failed
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }
}
