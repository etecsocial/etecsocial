<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresInfo extends Model {

    protected $table = 'professores_info';
    protected $guarded = [];


    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
    
        //para professores
    public function escolas() {
        return $this->hasMany('App\Escola');
    }


}
