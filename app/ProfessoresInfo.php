<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresInfo extends Model {

    protected $fillable = [
        'user_id',
        'id_escola',
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
