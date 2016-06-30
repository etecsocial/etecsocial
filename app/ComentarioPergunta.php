<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioPergunta extends Model {

    protected $table = 'comentarios_pergunta';
    protected $fillable = [
        'id',
        'grupo_id',
        'user_id',
        'id_pergunta',
        'comentario',
    ];

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
