<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlunosTurma extends Model {

    protected $table = 'alunos_turma';
    protected $fillable = [
        'user_id',
        'id_turma',
        'modulo'
    ];

}
