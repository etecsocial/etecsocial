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
        return Grupo::where('id', $id)->limit(1)->first();
    }

    public function makeUrl($nome) {
        $url = str_replace(' ', '', $nome);
        $cont = 1;
        if (Grupo::where('url', $url)->select('id')->first()) {
            $nova = $url.$cont;
            while (Grupo::where('url', $nova)->select('id')->first()) {//falta deixar usar url de grupo expirado
                $cont++;
                $nova = $url.$cont;
            }
        }
        return isset($nova) ? $nova : $url;
    }

}
