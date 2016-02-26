<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoMaterial extends Model {
    
    protected $table = 'grupo_material';

    protected $fillable = [
        'id',
        'id_autor',
        'data',
        'tipo',
        'caminho',
        'nome',
        'id`_grupo'
    ];
}
