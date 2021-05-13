<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  //laravel软删除->BentoControlle
                                               //对数据库添加功能时需要在对应的model中添加路径！

class Bento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bentos';
}
