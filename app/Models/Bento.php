<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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


    public function get_bento_image_url(){
        $bento_id = $this->id;
        $bento_image = BentosImage::where('bento_id',$bento_id)->first();

        if ($bento_image == null ){

            return '/img/default-bento.jpeg';
        }

        //url方法会在前面自动加/storage
        return Storage::url($bento_image->image_url);
    }
}
