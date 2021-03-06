<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model {

    public $timestamps = false;
    protected $guarded = [];


    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     */
    public function turmas() {
        return $this->hasMany('App\Turma');
    }
    
    public static function ver($id)
            {
        return Escola::find($id);
            }

}
