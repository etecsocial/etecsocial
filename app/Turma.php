<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
	public $timestamps = false;
    
    protected $fillable = [
        'id',
        'id_escola',
        'nome',
        'sigla'
    ];
}
