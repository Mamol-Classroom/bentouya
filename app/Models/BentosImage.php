<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentosImage extends Model
{
    use HasFactory;

    protected $table = 'bentos_images';

    //通过laravel的model直接与外键进行相互关联 BelongsTo隶属关系（）多对一关系
    //相反，一对多关系，参考Model：Bento

    public function bento(){

        return $this->belongsTo(Bento::class,'bento_id');
    }

    public function get_bento(){
        return $this->bento;
    }


}
