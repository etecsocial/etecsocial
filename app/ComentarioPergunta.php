<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioPergunta extends Model
{

    protected $table    = 'comentarios_pergunta';
    protected $fillable = [
        'id',
        'id_grupo',
        'user_id',
        'id_pergunta',
        'comentario',
    ];
}
