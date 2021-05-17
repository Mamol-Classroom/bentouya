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
        // プロフィール
        $user = Auth::user();
        $user_id = Auth::id();

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

            $has_error = false;
            $label_name = [
                'email' => 'メールアドレス',
                'name' => '名前',
                'postcode' => '郵便番号',
                'prefecture' => '都道府県',
                'city' => '市区町村',
                'address' => '住所',
                'tel' => '電話番号',
            ];

            foreach ($data as $key => $value) {
                if ($value == '') {
                    $error_message[$key] = '请输入'.$label_name[$key];
                    $has_error = true;
                }
            }

            if ($has_error) {
                $request->session()->put('bento.error_message', $error_message);
                $request->session()->put('bento.data', $data);

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
                'name' => $user -> name,
                'postcode' =>$user -> postcode,
                'prefecture' => $user -> prefecture,
                'city' => $user -> city,
                'address' => $user -> address,
                'tel' => $user -> tel,
            ];
        }

        return view('mypage.index', [
            'error_message' => $error_message,
            'data' => $data
        ]);
    }

    public function passwordUpdate(Request $request)
   {
       $user=Auth::user();
       $user_password=$user->password;

       $error_message = $request->session()->get('password.error_message');
       $data = $request->session()->get('password.data');

       $request->session()->forget('password.error_message');
       $request->session()->forget('password.data');


       if ($error_message == '') {
           $error_message = [
               'password' => '',
               'newpassword' => '',
               'password_confirm' => '',
           ];
       }

       if ($data == '') {
           $data = [
               'newpassword' => '',
               'password_confirm' => '',
           ];
       }
       $has_error = false;

       if ($request->method() === 'POST') {

           $oldpassword = $request->post('password');
           $password_update = $request->post('newpassword');
           $password_confirm = $request->post('password_confirm');

           $data = [
               'newpassword' => $password_update,
               'password_confirm' => $password_confirm,
           ];

           $error_message = [
               'password' => null,
               'newpassword' => null,
               'password_confirm' => null,
           ];

           $has_error = false;

           $email = $user->email;   //不定义下边的判定登录用户旧密码将会报错，因为没有被引用
           if (!Auth::attempt(['email' => $email, 'password' => $oldpassword])) {
               //确定当前用户输入的旧密码是否正确
               $error_message['password'] = 'パスワードが間違いました';
               $has_error = true;
           }

           if ($password_update == '') {
               $error_message['newpassword'] = '新しいパスワードを入力してください';
               $has_error = true;
           }

           if ($password_confirm != $password_update) {
               $error_message['password_confirm'] = '変更したパスワードと一致ではありません';
               $has_error = true;
           }

           if ($has_error) {
               $request->session()->put('password.error_message', $error_message);
               $request->session()->put('password.data', $data);

               return redirect('/mypage/passwordupdate');
           }
           //变更密码存入数据库
           $changed_password = Hash::make($passwordupdate);
           $user->password = $changed_password;
           $user->save();
       }

<<<<<<< HEAD
            if ($has_error) {
                $request->session()->put('password.error_message', $error_message);
                $request->session()->put('password.data', $data);

                return redirect('/mypage/pw_update');
            }
        //变更密码存入数据库
           $changed_password = Hash:: make ($password_update);
           $user->password = $changed_password;
           $user->save();
=======
       if ($data == null) {
           $data = [
               'newpassword' => null,
               'password_confirm' => null,
           ];
       }

>>>>>>> 2dc2b41165c5923a764a1079f4a345acc0bc9c03

    return view('mypage.pw_update',[
           'user' => $user,
           'data'=>$data,
           'error_message'=>$error_message,
       ]);
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
}
