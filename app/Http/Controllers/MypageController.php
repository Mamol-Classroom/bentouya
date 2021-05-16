<?php

namespace App\Http\Controllers;
use App\Models\Bento;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        //通过laravel中的中间件->middleware('auth')来挡住未登录时的页面跳转
        //if(!Auth::check()){
        //   return redirect('login');
        //}

        //プロフィール
        $user = Auth::user();
        $user_id = Auth::id();

        $error_message = $request->session()->get('error_message');
        $data = $request->session()->get('data');

        $request->session()->forget('error_message');
        $request->session()->forget('data');

        if ($error_message == null) {
            $error_message = [
                'email' => null,
                'name' => null,
                'postcode' => null,
                'prefecture' => null,
                'city' => null,
                'address' => null,
                'tel' => null,

            ];
        }


            if ($data == null) {
                $data = [
                    'email' => $user -> email,
                    'name' =>$user -> name,
                    'postcode' => $user -> postcode,
                    'prefecture' => $user -> prefecture,
                    'city' => $user -> city,
                    'address' => $user -> address,
                    'tel' => $user -> tel,

                ];
            }




        $has_error = false;

        if ($request->method() === 'POST') {
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

        return view('mypage.index',[
            'data' => $data,
            'error_message' => $error_message,
        ]);
    }


    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        $user_password = $user->password;
        $user_id = Auth::id();

        $error_message = $request->session()->get('password_error_message');
        $data = $request->session()->get('password_data');

        $request->session()->forget('password_error_message');
        $request->session()->forget('password_data');


        if ($error_message == null) {
            $error_message = [
                'password' => null,
                'new_password' => null,
                'password_confirm' => null,
            ];
        }

        if ($data == null) {
            $data = [
                'new_password' => '',
                'password_confirm' => '',
            ];
        }

        $has_error = false;
        if ($request->method() === 'POST') {
            $old_password = $request->post('password');
            $new_password = $request->post('new_password');
            $password_confirm = $request->post('password_confirm');

            $data = [
                'new_password' => $new_password,
                'password_confirm' => $password_confirm,
            ];

            $email = $user->email;

            if (!Auth::attempt(['email' => $email, 'password' => $old_password])) {
                //确定当前用户输入的旧密码是否正确
                $error_message['password'] = 'パスワードが間違いました';
                $has_error = true;
            }

            if ($new_password == "") {
                $error_message['new_password'] = '新しいパスワードを入力してください';
                $has_error = true;
            }

            if ($new_password != $password_confirm) {
                $error_message['password_confirm'] = 'パスワードと一致ではありません';
                $has_error = true;
            }

            if ($has_error) {
                $request->session()->put('password_error_message', $error_message);
                $request->session()->put('password_data', $data);

                return redirect('/mypage/password-update');
            }

            //存值
            $hashed_password =Hash::make($new_password);
            $user->password = $hashed_password;
            $user->save();

            return redirect('/mypage/password-update-success');
        }

        return view('mypage.password_update',[
            'user' => $user,
            'data'=>$data,
            'error_message'=>$error_message,
        ]);

    }


    public function passwordUpdateSuccess(Request $request) {

      return view('mypage.password_update_success');

    }


    public function favourite(Request $request){

        //取得当前登陆人的id
        $user_id = Auth::id();

        //取得 favourite表中，user_id等于登陆人的便当id
        $bento_id_list=[];
// ログインしているユーザーIDが注目したデーターの取得(Array)
        $favourites =Favourite::where('user_id', $user_id)->get();
// $favouritesから弁当IDの取得して、$bento_id_listに追加
        foreach ($favourites as $favourite){
            // 該当弁当IDの取得
            $bento_id = $favourite->bento_id;
            // 該当弁当IDを$bento_id_listの末に追加
            $bento_id_list[] = $bento_id;
        }

        //  $bento_query = Bento::query();
        // foreach ($bento_id_list as $bento_id) {
        //      $bento_query->orWhere('id', $bento_id);
        //  }
        //$bentos = $bento_query->get();


// Bentosテーブルから、弁当のIDリストに基づいて弁当情報の取得
        $bentos = Bento::whereIn('id', $bento_id_list)->get();

        return view('mypage.favourite', ['bentos' => $bentos]);




        //通过便当id取得便当数据


        //将所得的便当数据传入模版
        //循环现实所有便当数据



    }

}
