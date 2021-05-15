<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{

    public function index(Request $request)
     {
        $user = Auth::user();

         $error_message = $request->session()->get('error_message');
         $data = $request->session()->get('data');

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
                 'email'=>'',
                 'name'=>'',
                 'postcode'=>'',
                 'prefecture'=>'',
                 'city'=>'',
                 'address'=>'',
                 'tel'=>'',
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
         }
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
    public function update(Request $request)
    {
        // プロフィール
        $error_message = [
            'email' => null,
            'postcode' => null,
            'prefecture' => null,
            'city' => null,
            'address' => null,
            'tel' => null,
            'name' => null,
        ];

        $data = [
            'email' => '',
            'postcode' => '',
            'prefecture' => '',
            'city' => '',
            'address' => '',
            'tel' => '',
            'name' => '',
        ];

        return view('mypage.update', [
            'data' => $data,
            'error_message' => $error_message
        ]);
    }
    public function password_change(Request $request)
    {

    }

}
