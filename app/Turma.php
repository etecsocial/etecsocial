<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
     protected $fillable = [
        'id',
        'id_escola',
        'nome',
        'sigla'
    ];
}
