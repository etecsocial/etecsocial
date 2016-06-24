<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelevanciaComentarios extends Model
{

    protected $table = 'relevancia_comentarios';

    protected $fillable = [
        'id_usuario',
        'comentario_id',
        'relevancia',
    ];

}
