<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDiscussao extends Model
{

    protected $table    = 'comentarios_discussao';
    protected $fillable = [
        'id',
        'id_grupo',
        'user_id',
        'id_discussao',
        'comentario',
    ];
}
