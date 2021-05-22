<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentoImage extends Model
{
    use HasFactory;

    protected $table = "bentos_images";

    public function bento()
    {
        return $this->belongsTo(Bento::class,'bento_id');  //一对多中多的model里写：belongsTo
    }

    public function get_bento()
    {
        return $this->bento;
    }

}
