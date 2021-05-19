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

 /**  public function no_profile_img_url_url(){
       $profile_img_url = User::query('profile_img_url',id);

        if ($profile_img_url == null ){

            return '/img/default-bento.jpeg';
        }

        //url方法会在前面自动加/storage
        return Storage::url($profile_img_url->profile_img_url);
    }*/

}
