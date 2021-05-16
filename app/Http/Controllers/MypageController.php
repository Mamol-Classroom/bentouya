<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
    /*
        public function image(Request $request, User $user) {

            // バリデーション省略
            $originalImg = $request->user_image;

            if($originalImg->isValid()) {
                $filePath = $originalImg->store('public');
                $user->image = str_replace('public/', '', $filePath);
                $user->save();
                return redirect("/user/{$user->id}")->with('user', $user);
            }
         */
}
