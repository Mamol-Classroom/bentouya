<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  //laravel软删除->BentoController

class Bento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bentos';
}
