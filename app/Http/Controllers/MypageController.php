<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Bento;
use App\Models\Favourite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MypageController extends Controller
{

    public function index(Request $request)
    {
        // プロフィール

        $user = Auth::user();  //使用User会报错

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
            $old_password = $request->post('password');  //post进来原密码
            $password_change = $request->post('password_change'); //指的是html中tag的name
            $password_change_confirm = $request->post('password_change_confirm');

            $data = [
                'password_change' => $password_change,
                'password_change_confirm' => $password_change_confirm,
            ];


            $email = $user->email;   //不定义下边的判定登录用户旧密码将会报错，因为没有被引用
            if (!Auth::attempt(['email' => $email, 'password' => $old_password])) {
                //确定当前用户输入的旧密码是否正确
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

    public function favourite(Request $request)
    {
        //ログインしているユーザーIDの取得
        $user_id = Auth::id();
        //favouritesテーブルから注目している弁当のIDリストの取得
        $bento_id_list = [];
        //ログインしているユーザーIDが注目したデーターの取得(Array)
        $favourites = Favourite::where('user_id',$user_id)->get();
        //$favouritesから弁当IDの取得して、$bento_id_listに追加
        foreach ($favourites as $favourite){
            //該当弁当IDの取得
            $bento_id = $favourite->bento_id;
            //該当弁当IDを$bento_id_listの末に追加
            $bento_id_list[] = $bento_id;
        }

        //Bentosテーブルから、弁当のIDリストに基づいて弁当情報の取得
        $bentos = Bento::whereIn('id',$bento_id_list)->get();  //whereIn定点查询

        return view('mypage.favourite',[
            'bentos'=>$bentos
        ]);
    }


}







