<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}
