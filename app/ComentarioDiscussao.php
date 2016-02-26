<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDiscussao extends Model {

    protected $table = 'comentarios_discussao';
    protected $fillable = [
        'id',
        'id_grupo',
        'id_user',
        'id_discussao',
        'comentario'
    ];
}
