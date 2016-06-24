<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'id_post',
        'user_id',
        'comentario',
    ];

    public static function loadComentarios($id_post)
    {
        return Comentario::where('id_post', $id_post)
            ->get();
    }
}
