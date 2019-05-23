<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioPergunta extends Model {

    protected $table = 'comentarios_pergunta';
    protected $guarded = [];


    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function pergunta() {
        return $this->belongsTo('App\GrupoPergunta');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
