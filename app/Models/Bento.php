<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;

class Bento extends Model
{
    use HasFactory;
    //软删除 数据库同时添加deleted_at字符
    use SoftDeletes;

    protected $table = 'bentos';
    public $timestamps = false;

}
