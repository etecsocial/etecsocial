<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlunosInfo extends Model {

    protected $table = 'alunos_info';
    protected $fillable = [
        'user_id',
        'id_turma',
        'id_escola',
    ];

}
