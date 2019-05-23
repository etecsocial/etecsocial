<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioDiscussao extends Model {

    protected $table = 'comentarios_discussao';
    protected $guarded = [];

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
