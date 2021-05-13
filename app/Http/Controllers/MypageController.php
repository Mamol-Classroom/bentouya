<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        // プロフィール
        $user = Auth::user();  //使用User会报错？
        // $user_id = Auth::id(); 在session中取得旧文件，而不是直接从数据库中提取新数据

        $error_message = $request->session()->get('error_message');
        $data = $request->session()->get('data');

        $error_message = $request->session()->forget('error_message');
        $data = $request->session()->forget('data');

        if($error_message == ''){
            $error_message = [
                'email'=>'',
                'password'=>'',
                'name'=>'',
                'postcode'=>'',
                'prefecture'=>'',
                'city'=>'',
                'address'=>'',
                'tel'=>'',
            ];
        }

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

        $has_error = false;

        if($request->method() == 'POST'){
            $email = $request->post('email');
            $name = $request->post('name');
            $postcode = $request->post('postcode');
            $prefecture = $request->post('prefecture');
            $city = $request->post('city');
            $address = $request->post('address');
            $tel = $request->post('tel');

            $data = [
                'email'=>$email,
                'name'=>$name,
                'postcode'=>$postcode,
                'prefecture'=>$prefecture,
                'city'=>$city,
                'address'=>$address,
                'tel'=>$tel,
            ];

            $label_name = [
                'email'=>'メールアドレス',
                'name'=>'名前',
                'postcode'=>'郵便番号',
                'prefecture'=>'都道府県',
                'city'=>'市区町村',
                'address'=>'住所',
                'tel'=>'電話番号',
            ];

            foreach($data as $key=>$value){
                if($value = ''){
                    $error_message[$key] = $label_name[$key].'を入力してください';
                    $has_error = true;
                }
            }

            if($has_error){
                $request->session()->put('error_message',$error_message);
                $request->session()->put('data',$data);

                return redirect('/mypage');
            }

            //将更新数据存入数据库

            $user->email = $email;
            $user->name = $name;
            $user->postcode = $postcode;
            $user->prefecture = $prefecture;
            $user->city = $city;
            $user->address = $address;
            $user->tel = $tel;
            $user->save();

        }

    return view('mypage.index',[
        'data'=>$data,
        'error_message'=>$error_message,
    ]);

        // プロフィール
       /** $data = [
            'email' => '',
            'postcode' => '',
            'prefecture' => '',
            'city' => '',
            'address' => '',
            'tel' => '',
            'name' => '',
        ];

        //$user = Auth::user(); 在session中取得旧文件，而不是直接从数据库中提取新数据
        //$user_id = Auth::id();

        $user = User::find(user_id);


        $user = User::find($user_id);

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

         $request->session()->put('data',$data);

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
            $user->name = $data['name'];
            $user->postcode = $data['postcode'];
            $user->prefecture = $data['prefecture'];
            $user->city = $data['city'];
            $user->address = $data['address'];
            $user->tel = $data['tel'];
            $user->save();

            return redirect('/mypage');
        }

        return view('mypage.index', [
            'data' => $data,
        ]);*/
    }
    public function passwordChange(Request $request)
    {
        $user = Auth::user();
        $user_password = $user->password;

        $error_message = $request->session()->get('ps_error_message');
        $data = $request->session()->get('ps_data');

        $request->session()->forget('ps_error_message');
        $request->session()->forget('ps_data');

        if ($error_message == '') {
            $error_message = [
                'password' => '',
                'password_change' => '',
                'password_change_confirm' => '',
            ];
        }

        if ($data == '') {
            $data = [
                'password_change' => '',
                'password_change_confirm' => '',
            ];
        }

        $has_error = false;

        if ($request->method() == 'POST') {
            $old_password = $request->post('password');
            $password_change = $request->post('password_change');
            $password_change_confirm = $request->post('password_change_confirm');

            $data = [
                'password_change' => $password_change,
                'password_change_confirm' => $password_change_confirm,
            ];

            $email = $user->email;
            if (!Auth::attempt(['email' => $email, 'password' => $old_password])) {
                $error_message['password'] = 'パスワードが間違いました';
                $has_error = true;
            }

            if ($password_change == '') {
                $error_message['password_change'] = '新しいパスワードを入力してください';
                $has_error = true;
            }

            if ($password_change_confirm != $password_change) {
                $error_message['password_change_confirm'] = '変更したパスワードと一致ではありません';
                $has_error = true;
            }

            if ($has_error) {
                $request->session()->put('ps_error_message', $error_message);
                $request->session()->put('ps_data', $data);

                return redirect('/mypage/password-change');
            }
            //变更密码存入数据库
            $changed_password = Hash::make($password_change);
            $user->password = $changed_password;
            $user->save();

        }

        return view('mypage.password-change',[
            'user' => $user,
            'data'=>$data,
            'error_message'=>$error_message,
        ]);

    }


}







