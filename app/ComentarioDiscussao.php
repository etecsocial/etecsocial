<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDiscussao extends Model {

    protected $table = 'comentarios_discussao';
    protected $fillable = [
        'id',
        'grupo_id',
        'user_id',
        'discussao_id',
        'comentario',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function discussao() {
        return $this->belongsTo('App\GrupoDiscussao');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
}
