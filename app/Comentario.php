<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'id_post',
        'id_user',
        'comentario',
    ];

    public static function loadComentarios($id_post)
    {
        return Comentario::where('id_post', $id_post)
            ->get();
    }
}
