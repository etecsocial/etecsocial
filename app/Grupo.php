<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model {

    protected $table = 'grupo';
    protected $fillable = [
        'id',
        'nome',
        'url',
        'expiracao',
        'materia',
        'assunto',
        'id_criador',
        //@todo tirar esses tres campos, somos melhores que isso.
        'num_participantes',
        'num_discussoes',
        'num_perguntas',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsToMany('App\User');
    }

    public function turma() {
        return $this->belongsTo('App\Turma');
    }
    public function discussao() {
        return $this->hasMany('App\GrupoDiscussao');
    }
    public function pergunta() {
        return $this->hasMany('App\GrupoPergunta');
    }
    public function materiais() {
        return $this->hasMany('App\GrupoMaterial');
    }
    public function atvs() {
        return $this->hasMany('App\GrupoAtv');
    }
    
    

    public static function verGrupo($id) {
        return Grupo::find($id);
    }
    
    

    public static function makeUrl($sigla, $modulo) {
        $url = str_replace(' ', '', $modulo . $sigla . date('Y'));
        $cont = 1;
        if (Grupo::where('url', $url)->select('id')->first()) {
            $nova = $url . $cont;
            while (Grupo::where('url', $nova)->select('id')->first()) {
            //@todo falta deixar usar url de grupo expirado
                $cont++;
                $nova = $url . $cont;
            }
        }
        return isset($nova) ? $nova : $url;
    }

}
