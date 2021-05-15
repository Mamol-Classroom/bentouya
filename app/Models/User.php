<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;

 /**  public function no_avatar_url(){
       $avatar = User::query('avatar',id);

        if ($avatar == null ){

            return '/img/default-bento.jpeg';
        }

        //url方法会在前面自动加/storage
        return Storage::url($avatar->avatar);
    }*/

}
