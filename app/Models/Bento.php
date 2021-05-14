<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Bento extends Model
{
    use HasFactory;
    use softdeletes;

    protected $table = 'bentos';


    public function is_favourite($user_id)
    {
        $bento_id = $this->id;
        $favourite = Favourite::where('user_id', $user_id)
            ->where('bento_id', $bento_id)
            ->first();

        return $favourite != null;
    }
}
