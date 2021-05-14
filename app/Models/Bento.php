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

    //数据库里有created at就可以不要
    //public $timestamps = false;

    public function is_favourite($user_id){
        $bento_id =$this -> id;
        $favourite =Favourite::where('user_id',$user_id)
            ->where('bento_id',$bento_id)
            ->first();

        return $favourite != null;
    }

}
