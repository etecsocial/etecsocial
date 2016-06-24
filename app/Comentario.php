<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comentario',
    ];

    public static function loadComentarios($post_id)
    {
        return Comentario::where('post_id', $post_id)
            ->get();
    }
}
