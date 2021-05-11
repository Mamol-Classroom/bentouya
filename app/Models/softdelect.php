<?php


namespace App\Models;

use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class post extends Model
{
    use softdeletes;
    public $table = 'bento';
    public $primarykey = 'id';
    public $dateFormat = 'U';
    protected $guarded =['id','views','bento_id','updated_at','created_at'];
    protected $dates =['delete_at'];

}
