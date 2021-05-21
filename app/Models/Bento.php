<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Bento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bentos';

    public function bento_images()
    {
        return $this->hasMany(BentosImage::class, 'bento_id', 'id');
    }

    public function is_favourite($user_id)
    {
        $bento_id = $this->id;
        $favourite = Favourite::where('user_id', $user_id)
            ->where('bento_id', $bento_id)
            ->first();

        return $favourite != null;
    }

    public function get_bento_image_url()
    {
        $bento_image = $this->bento_images()->first();
        if ($bento_image == null) {
            return '/img/default-bento.jpg';
        }

        return Storage::url($bento_image->image_url);
    }
}
