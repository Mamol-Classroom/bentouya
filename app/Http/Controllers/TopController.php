<?php

namespace App\Http\Controllers;

use App\Rules\EqualWithValue;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TopController extends Controller
{

    public function top(Request $request)
    {
        $word = $request->query('word');
        $price_l = $request->query('price_l');
        $price_h = $request->query('price_h');

        $bento_query = Bento::query()->where('stock', '>', 0);

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

        $add_to_cart_bento_id = $request->session()->get('add_cart_bento');
        if ($add_to_cart_bento_id != null) {
            $add_to_cart_bento = Bento::find($add_to_cart_bento_id);
        } else {
            $add_to_cart_bento = null;
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
        return view('register');
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



        $rules = [
            'email' => ['required', 'email'],
            'password' => 'required',
            'password_confirm' => [new EqualWithValue($data['password'])],
            'postcode' => 'required',
            'prefecture' => 'required',
            'city' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'name' => 'required'
        ];

        $messages = [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式がまちがいました',
            'password.required' => 'パスワードを入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'prefecture.required' => '都道府県を入力してください',
            'city.required' => '市区町村を入力してください',
            'address.required' => '住所を入力してください',
            'tel.required' => '電話番号を入力してください',
            'name.required' => '名前を入力してください',
        ];

        $validator = Validator::make($data, $rules, $messages);
        $validator->validate();

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
                return redirect(route('top'));
            } else {
                // ログイン失敗
                $request->session()->put('login_failed', true);

                //return redirect(route('get_login'));
                return redirect()->route('get_login');
            }

            /**
            $user = User::where('email', $email)->first();
            if ($password == $user->password) {
                // ログイン成功
                return redirect(route('top'));
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
