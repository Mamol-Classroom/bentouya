<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
