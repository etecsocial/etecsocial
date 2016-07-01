<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesafioTurma extends Model
{
    public $timestamps = false;
    public $fillable = ['desafio_id', 'turma_id'];

    public function turma()
    {
        return $this->belongsTo('App\Turma');
    }
}
