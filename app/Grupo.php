<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model {

    protected $table = 'grupo';
    protected $fillable = [
        'id',
        'nome',
        'criacao',
        'expiracao',
        'materia',
        'assunto',
        'id_criador',
        'num_participantes',
        'num_discussoes',
        'num_perguntas'
    ];

    public static function verGrupo($id) {
        return Grupo::where('id', $id)->first();
    }


}
