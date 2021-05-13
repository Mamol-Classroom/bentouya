<?php

namespace App\Http\Controllers;

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
       //$emptymsg="お買い物を始めよう";
       $wannaId=DB::table('favourites')->orderBy('id','bento_id');
      // if($wannaId==null)
       //    return view('expect', ['emptymsg=>$emptymsg']);
     //  else
           return view('expection',['wannaId'=>$wannaId]);

  }
}
