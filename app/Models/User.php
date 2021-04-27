<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;//修改时报错：laravel每个表里默认有creat_at创建时间,和update_at更新时间
}
