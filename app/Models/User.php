<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;


   /** public function get_user_image_url()
    {
        $user_id = auth::id();
        $user_img = User::where('id', $user_id)->first();
        if ($user_img == null) {
            return 'img/default-user.jpg';
        }

        return Storage::url($user_img->image_url);
    }*/
}
