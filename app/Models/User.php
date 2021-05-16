<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //将User重命名，避免和下边其他路径的User重复
                                                        //可认证、加密
                                                        //对数据库添加功能时需要在对应的model中添加路径！
use Illuminate\Support\Facades\Storage;      //创建头像文件夹

class User extends Authenticatable  //寻找config文件夹下的auth.php文件进行配置(从下向上寻找)
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;//改增时报错：laravel每个表里默认有create_at创建时间,和update_at更新时间

    public function get_user_headPortrait_url($id,$user)
    {
        $user->headPortrait_url = User::where('id',$id)->first();

        if($user->headPortrait_url == ''){
            return '/img/用户默认头像.jpg';
        }

        return Storage::url($user->headPortrait_url);
    }
}
