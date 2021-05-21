<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentosImage extends Model
{
    use HasFactory;

    protected $table = 'bentos_images';

    public function bento()
    {
        return $this->belongsTo(Bento::class, 'bento_id');
    }

    public function get_bento()
    {
        return $this->bento;
    }
}
