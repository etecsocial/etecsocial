<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDiscussao extends Model
{

    protected $table    = 'comentarios_discussao';
    protected $fillable = [
        'id',
        'grupo_id',
        'user_id',
        'id_discussao',
        'comentario',
    ];
}
