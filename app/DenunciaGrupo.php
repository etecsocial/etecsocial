<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DenunciaGrupo extends Model {

    protected $table = 'denuncias_grupo';
    protected $fillable = [
        'tipo',
        'id_pub',
        'denuncia',
        'data',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function grupo() {
        return $this->belongsTo('App\Grupo');
    }

}
