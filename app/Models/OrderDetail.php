<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';

    public function get_bento_img()
    {
        $bento_id = $this->bento_id;
        $bento_image = BentoImage::where('bento_id',$bento_id)->first();
        if($bento_image == null){
            return '/img/default-bento.jpg';
        }

        return Storage::url($bento_image->image_url);
    }
}
