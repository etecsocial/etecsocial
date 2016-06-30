<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Desafio extends Model {

    public $responsible = 'Professor UNK';

    public function responsible() {
        return User::select('name')->where('id', $this->responsible_id)->limit(1)->first()->name;
    }

    /**
     * Eduardo, faça as relações de acordo com sua lógica, não sei como você ia querer aqui.
     */
//    public function user() {
//        return $this->belongsTo('App\User');
//    }
//
//    public function user() {
//        return $this->belongsTo('App\User');
//    }

}
