<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoTurma extends Model {
    protected $table = 'grupo_turma';
    protected $fillable = [
        'turma_id',
        'grupo_id',
        'modulo'
    ];

}
