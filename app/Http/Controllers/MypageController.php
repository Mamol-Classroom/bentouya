<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
