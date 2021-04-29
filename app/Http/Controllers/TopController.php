<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TopController extends Controller
{

    public function top(Request $request)
    {
        if (Auth::check()) {
            return view('top');
        } else {
            return redirect('/login');
        }
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
/**

    public function userList(Request $request){
        $users = User::all();
        foreach($users as $u){
            echo $u->name;
            echo '<br>';
            echo $u->id;
            //find方法查询  $users = find(2);
            //get方法查询  $users = User::where('postcode','1234567')->get();
            //fist方法与get类似  $users = User::where('postcode','1234567')->first();
            //修改: 查询  $users = User::find(4);
            //     修改  $users->postcode = '1234567';
            //   保存数据 $user -> save();
            //插入    $user = new User();
            //       $user->email = 'test6@test.com';
            //       $user->password = '1234';
            //       $user->name = 'test6';
            //       $user->save();
            //删除    $users = find(4);
            //       $users->delete();
        }
*/
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

        $request->session()->put('registed_user', $user);

        return redirect('/register-success');
    }

    public function registerSuccess(Request $request)
    {
        $user = $request->session()->get('registed_user');
        $request->session()->forget('registed_user'); //?

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
                $request->session()->put('login_failed', true);//保存以及修改put('名字‘,值)
                                                                //flash闪存

                return redirect('/login');
            }
             */
        }

        $login_failed = $request->session()->get('login_failed');//取值get
        $request->session()->forget('login_failed');//删除forget

        return view('login', [
            'login_failed' => $login_failed
        ]);
    }
}
