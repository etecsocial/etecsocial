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
        'id_turma',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function user() {
        return $this->hasMany('App\User');
    }

    public function turma() {
        return $this->hasMany('App\Turma');
    }

    public static function loada() {
        $age = Agenda::where('user_id', auth()->user()->id)->where('start', '>', time())->get()->first();

        return (empty($age)) ? false : $age;
    }

}
