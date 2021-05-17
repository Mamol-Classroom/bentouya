<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;
    /**
     * @var array|mixed|string|null
     */

    public function get_user_image_url()
    {
        $user_id = $this->id;
        $user_image = User::where('user_id', $user_id)->first();
        if ($user_image == null) {
            return '/img/default-bento.jpg';
        }
        return Storage::url($user_image->image_url);
    }
}
