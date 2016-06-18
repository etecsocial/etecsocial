<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresTurma extends Model {

    protected $table = 'professores_turma';
    protected $fillable = [
        'user_id',
        'id_turma',
        'id_escola',
        'modulo'
    ];

}
