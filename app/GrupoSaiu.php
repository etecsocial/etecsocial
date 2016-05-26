<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoSaiu extends Model
{

    protected $table = 'grupo_saiu';

    protected $fillable = [
        'id',
        'id_grupo',
        'id_user',
        'data',
        'motivo',
    ];

}
