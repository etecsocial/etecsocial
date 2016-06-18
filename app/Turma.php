<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
	public $timestamps = false;
        protected $table = 'turmas';
    
    protected $fillable = [
        'nome',
        'sigla',
        'id_escola',
        'modulos'
    ];
}
