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

    //关于model的处理可以直接写在对应的model里；
    //这里是要关联top页面以及mypage中的注目リスト，使收藏内容同步，并可以在注目リスト中取消收藏
    public function is_favourite($user_id)  //在top.blade中添加一个ajax来完成同步
    {
        $bento_id = $this->id;
        $favourite = Favourite::where('user_id',$user_id)
            ->where('bento_id',$bento_id)
            ->first();

        return $favourite != '';  //不为空表示已经被收藏
    }
}
