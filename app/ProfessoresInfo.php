<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresInfo extends Model {

    protected $table = 'professores_info';
    protected $fillable = [
        'user_id',
        'id_turma',
        'id_escola',
    ];

}
