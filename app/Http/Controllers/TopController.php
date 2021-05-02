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
        if(Auth::check()){
            $user = Auth::user();
            $user_id =Auth::id();

            $bentos = Bento::all();


            return view('top',[
                'name' => $user->name,
                'bentos' =>$bentos
            ]);
        }else{
            return redirect('login');
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
        $user = new User();
        $user->email = $email;
        $hashed_password =Hash::make($password);
        $user->password = $hashed_password;
        $user->name = $name;
        $user->postcode = $postcode;
        $user->prefecture = $prefecture;
        $user->city = $city;
        $user->address = $address;
        $user->tel = $tel;
        $user->save();

        $request->session()->put('register_user',$user);


        return redirect('/register_success');

    }


    public function registerSuccess(Request $request)

    {

        $user = $request->session()->get('register_user');


        return view('register_success',[
            'email' => $user->email,
            'name' => $user->name,
            'postcode' => $user->postcode,
            'prefecture' => $user->prefecture,
            'city' => $user->city,
            'address' => $user->address,
            'tel' => $user->tel,


            ]);

    }
            //数据库查验密码是否正确
    public function login(Request $request)
             {
                 if ($request->method() == 'POST') {
                     $email = $request->post('email');
                     $password = $request->post('password');


                     if (Auth::attempt(['email'=>$email,'password'=>$password])){

                         return redirect('/');

                     } else {

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



        //$users = User::all();
        //$user = User::find(2);
        //$users = User::where('postcode', '1234567')->get();
        //$user = User::where('postcode', '1234567')->first();

        // 編集
        //$user = User::find(4);
        //$user->postcode = '7654321';
        //$user->save();

        // 新規
        /**
        $user = new User();
        $user->id = 1;
        $user->email = 'email';
        $user->password = 'password';
        $user->name = 'name';
        $user->postcode = 'postcode';
        $user->prefecture = 'prefecture';
        $user->city = 'city';
        $user->tel = 'tel';
        $user->save();
        */

        // 削除
        /**
        $user = User::find(10);
        if ($user != null) {
            $user->delete();

        }
         */

    public function bentoRegister(Request $request)
    {

        $bento_error_message = $request->session()->get('bento_error_message');
        $bento_data = $request->session()->get('bento_data');

        if ($bento_error_message == null) {
            $bento_error_message = [
                'bento_name' => null,
                'price' => null,
                'bento_code' => null,
                'description' => null,
                'guarantee_period' => null,
                'stock' => null,
                'user_id' => null,

            ];
        }

        if ($bento_data == null) {
            $bento_data = [
                'bento_name' => '',
                'price' => '',
                'bento_code' => '',
                'description' => '',
                'guarantee_period' => '',
                'stock' => '',
                'user_id' => '',

            ];
        }

        return view('bento_register', [
            'bento_error_message' => $bento_error_message,
            'bento_data' => $bento_data
        ]);
    }

    public function bentoRegisterUser(Request $request)
    {
        $bento_name = $request->post('bento_name');
        $price = $request->post('price');
        $bento_code = $request->post('bento_code');
        $description = $request->post('description');
        $guarantee_period = $request->post('guarantee_period');
        $stock = $request->post('stock');
        $user_id = $request->post('user_id');


        $bento_data = [
            'bento_name' => $bento_name,
            'price' => $price,
            'bento_code' => $bento_code,
            'description' => $description,
            'guarantee_period' => $guarantee_period,
            'stock' => $stock,
            'user_id' => $user_id,

        ];

        $has_bento_error = false;
        $bento_error_message = [
            'bento_name' => null,
            'price' => null,
            'bento_code' => null,
            'guarantee_period' => null,
            'stock' => null,
            'user_id' => null,

        ];
        if ($bento_name == "") {
            $bento_error_message['bento_name']  = '弁当名を入力してください';
            $has_bento_error = true;
        }

        if ($price == "") {
            $bento_error_message['price']  = '価格を入力してください';
            $has_bento_error = true;
        }

        if ($bento_code == "") {
            $bento_error_message['bento_code']  = '弁当コードを入力してください';
            $has_bento_error = true;
        }

        if ($guarantee_period == "") {
            $bento_error_message['guarantee_period']  = '賞味期限を入力してください';
            $has_bento_error = true;
        }

        if ($stock == "") {
            $bento_error_message['stock']  = '在庫数を入力してください';
            $has_bento_error = true;
        }

        if ($user_id == "") {
            $bento_error_message['user_id']  = 'ユーザーIDを入力してください';
            $has_bento_error = true;
        }

        if ($has_bento_error) {
            $request->session()->put('bento_error_message', $bento_error_message);
            $request->session()->put('bento_data', $bento_data);
        }


        if ($has_bento_error) {
            $request->session()->put('error_message', $bento_error_message);
            $request->session()->put('data', $bento_data);

            return redirect('/bento_register');}


        $bento = new Bento();
        $bento->bento_name = $bento_name;
        $bento->price = $price;
        $bento->bento_code = $bento_code;
        $bento->description = $description;
        $bento->guarantee_period = $guarantee_period;
        $bento->stock = $stock;
        $bento->user_id = $user_id ;
        $bento->save();

        $request->session()->put('bento-register-user',$bento);


        return redirect('/bento_register_success');

    }


    public function bentoRegisterSuccess(Request $request)

    {

        $bento = $request->session()->get('bento-register-user');


        return view('bento_register_success',[
            'bento_name' => $bento->bento_name,
            'price' => $bento->price,
            'bento_code' => $bento->bento_code,
            'description' => $bento->description,
            'guarantee_period' => $bento->guarantee_period,
            'stock' => $bento->stock,
            'user_id' => $bento->user_id,


        ]);

    }

}
