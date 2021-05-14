<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class bento extends Model
{
    use HasFactory;
    use softdeletes;
    protected $table = 'bento';
}
