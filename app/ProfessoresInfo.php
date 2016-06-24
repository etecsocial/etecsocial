<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresInfo extends Model {
    protected $table    = 'professores_info';

    protected $fillable = [
        'user_id',
        'escola_id',
        'profile_photo',
        'status',
        'cidade',
        'formacao',
        'email',
        'livro',
        'filme',
        'materia',
    ];

}
