<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
<<<<<<< HEAD
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
>>>>>>> 40a48097d336a303e66b9f31595748f411a87a48

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
<<<<<<< HEAD

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

    public function mydetail(Request $request)
    {
        Auth::check();
        $user=Auth::user();
        $user_id=Auth::id();
        $old_password=$user->password;



        return view('mypage.mydetail');
    }
=======
    public function expection(Request $request){
        // 取得当前登录的人的ID
        // 取得favourite表中，user_id等于登陆人ID的便当ID
        // 通过便当ID取得便当数据
        // 将所得的便当数据传入模板
        // 循环显示所有便当数据

        $user_id = Auth::id();

        $favourites = Favourite::where('user_id', $user_id)->get();
        $bento_id_list = [];
        foreach ($favourites as $favourite) {
            $bento_id = $favourite->bento_id;
            $bento_id_list[] = $bento_id;
        }

        $bento_query = Bento::query();
        foreach ($bento_id_list as $bento_id) {
            $bento_query->orWhere('id', $bento_id);
        }
        $bentos = $bento_query->get();

        $bentos = Bento::whereIn('id', $bento_id_list)->get();

        return view('expection', ['bentos' => $bentos]);

       //$emptymsg="お買い物を始めよう";
       $wannaId=DB::table('favourites')->orderBy('id','bento_id');
      // if($wannaId==null)
       //    return view('expect', ['emptymsg=>$emptymsg']);
     //  else
           return view('expection',['wannaId'=>$wannaId]);

  }
>>>>>>> 40a48097d336a303e66b9f31595748f411a87a48
}

