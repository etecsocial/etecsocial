<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoMaterial extends Model
{

    protected $table = 'grupo_material';

    protected $fillable = [
        'id',
        'autor_id',
        'data',
        'tipo',
        'caminho',
        'nome',
        'id`_grupo',
    ];
}
