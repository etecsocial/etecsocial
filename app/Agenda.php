<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model {

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
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function users() {
        return $this->hasMany('App\User');
        
        //IMPORTANTE
        //PASSAR PARA N PRA N!! CRIAR TABELA AGENDA_USERS
        //IMPORTANTE
        
    }

    public function turma() {
        return $this->hasMany('App\Turma');
    }

    public static function loada() {
        $age = Agenda::where('user_id', auth()->user()->id)->where('start', '>', time())->get()->first();

        return (empty($age)) ? false : $age;
    }

}
