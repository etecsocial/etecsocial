<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model {

    public $timestamps = false;
    protected $table = 'turmas';
    protected $fillable = [
        'nome',
        'sigla',
        'escola_id',
        'modulos'
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function user() {
        return $this->hasMany('App\User');
    }
    public function agenda() {
        return $this->hasMany('App\Agenda');
    }
    public function grupo() {
        return $this->belongsTo('App\Grupo');
    }
    public function escola() {
        return $this->belongsTo('App\Escola');
    }
    public function desafios() {
        return $this->hasMany('App\Desfio');
    }
}
