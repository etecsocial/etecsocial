<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesafioResposta extends Model
{
    public function aluno() {
        return $this->belongsTo('App\User');
    }

    public function desafio() {
        return $this->hasMany('App\Desafio');
    }
}
