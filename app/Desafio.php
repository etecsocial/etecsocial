<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Desafio extends Model {

    public function responsible() {
        return $this->belongsTo('App\User');
    }

    public function turmas() {
        return $this->hasMany('App\DesafioTurma');
    }

}
