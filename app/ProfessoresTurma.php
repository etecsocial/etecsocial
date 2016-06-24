<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresTurma extends Model {

    protected $table = 'professores_turma';
    protected $fillable = [
        'user_id',
        'turma_id',
        'modulo'
    ];

}
