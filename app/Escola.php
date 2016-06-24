<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model {

    protected $table = 'escolas';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'cod_prof',
        'cod_coord',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     */
    public function turma() {
        return $this->hasMany('App\Turma');
    }

}
