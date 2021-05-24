<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\BentosImage;
use App\Http\Requests\checkmsg;
use Illuminate\Support\Facades\Hash;
class MypageController extends Controller
{

    public function index(Request $request)
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

        return view('mypage.index', [
            'data' => $data,
            'error_message' => $error_message
        ]);
    }

    public function favourite(Request $request)
    {
        // ログインしているユーザーIDの取得
        $user_id = Auth::id();
        // favouritesテーブルから注目している弁当のIDリストの取得
        $bento_id_list = [];
        //        // ログインしているユーザーIDが注目したデーターの取得(Array)
        //        $favourites = Favourite::where('user_id', $user_id)->get();
        //        // $favouritesから弁当IDの取得して、$bento_id_listに追加
        $favourites = Favourite::where('user_id', $user_id)->get();
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

    public function mydetail(Request $request){


        return view('mypage.mydetail');
    }

    public function changecheck(Request $request){

        if(Auth::check()){
            $user=Auth::user();
            $user_id=Auth::id();
        }

        $realpass=User::where('password',$user_id);

    if($request->method()==='POST'){
        $oddpass=$request->post('oddpass');
        $newpass=$request->post('newpass');
        $comfirmpass=$request->post('confirmpass');
    }
        $getmsg=[
          'getpass'=>$oddpass,
          'getnewpass'=>$newpass,
          'getcomfirmpass'=>$comfirmpass,
];
        $errormsg=[
          'errormsg1'=>'两次输入的密码不一致',
          'errormsg2'=>'输入的密码不正确'
];

    }




}
