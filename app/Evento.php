<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model {

    protected $fillable = [
        'id',
        'title',
        'description',
        'start',
        'end',
        'user_id',
        'is_publico',
        'turma_id',
    ];

    /**
     * Ver se, no caso de relacionar o evento com a escola, por exemplo, precisa preencher a tabela pivot de turma e de usuario
     * @return \Iluminate\Database\Elequoment\Relations\BelongsToMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    public function turmas() {
        return $this->belongsToMany('App\Turmas')->withTimestamps();
    }
    public function escolas() {
        return $this->belongsTo('App\Escola')->withTimestamps();
    }

    public static function loada() { //@todo vai saber o que é isso que o marcio fez kkkkk
        $age = Evento::where('user_id', auth()->user()->id)->where('start', '>', time())->get()->first();

        return (empty($age)) ? false : $age;
    }

}
