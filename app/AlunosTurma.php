<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlunosTurma extends Model {

    protected $table = 'alunos_turma';
    protected $guarded = [];


    public function turma(){
        return $this->belongsTo('App\Turma');
    }

    public function students(){
        return $this->hasMany('App\User');
    }

}
