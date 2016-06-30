<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoDiscussao extends Model {

    protected $table = 'grupo_discussao';
    protected $fillable = [
        'id',
        'autor_id',
        'user_id',
        'assunto',
        'discussao',
        'grupo_id',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function comentarios() {
        return $this->hasMany('App\ComentarioDiscussao');
    }

    public function grupo() {
        return $this->belongsTo('App\Grupo');
    }

    public function getNumDiscussoes($grupo_id) {
        return GrupoDiscussao::where('grupo_id', $grupo_id)->count();
    }

}
