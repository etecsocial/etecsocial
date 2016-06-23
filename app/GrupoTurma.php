<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoTurma extends Model {
    protected $table = 'grupo_turma';
    protected $fillable = [
        'id_turma',
        'id_grupo',
        'modulo'
    ];

}
