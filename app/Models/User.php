<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //将User重命名，避免和下边其他路径的User重复

class User extends Authenticatable  //寻找config文件夹下的auth.php文件进行配置(从下向上寻找)
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;//改增时报错：laravel每个表里默认有create_at创建时间,和update_at更新时间
}
