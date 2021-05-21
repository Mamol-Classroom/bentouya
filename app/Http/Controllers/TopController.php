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

        return view('top', [
            'bentos' => $bentos,
            'word' => $word,
            'price_l' => $price_l,
            'price_h' => $price_h,
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

        return view(route('get_register'), [
            'error_message' => $error_message,
            'data' => $data
        ]);
    }

    public function registerUser(Request $request)
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
        $profile_img_url = $request->file('profile_img_url');

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
            $error_message['email']  = 'メールアドレスをご入力ください';
            $has_error = true;
        }

        if ($password == "") {
            $error_message['password']  = 'パスワードをご入力ください';
            $has_error = true;
        }

        if ($password != $password_confirm) {
            $error_message['password_confirm']  = 'パスワード一致ではありません';
            $has_error = true;
        }

        if ($name == "") {
            $error_message['name']  = '名前をご入力ください';
            $has_error = true;
        }

        if ($postcode == "") {
            $error_message['postcode']  = '郵便番号をご入力ください';
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

            return redirect(route('get_register'));
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

        if ($profile_img_url != null){
            $profile_img_url->storeAs('public/profile_img_urls/',$profile_img_url->getClientOriginalName());
            $user->profile_img_url = 'profile_img_urls'.$profile_img_url->getClientOriginalName();
        }

        //$profile_img_url_name = $user->name.'.'.$profile_img_url->extension();
        //$profile_img_url->storeAs('public/profile_img_urls'.$user->id,$profile_img_url_name);

        //$user_image = new UsersImage();
        //$user_image -> user_id = $user -> id;
        //$user_image -> profile_img_url_url = 'profile_img_urls'.$user->id.'/'.$profile_img_url_name;
        //$user_image -> save();

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
