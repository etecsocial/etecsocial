<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoAtiv extends Model {

    protected $table = 'grupo_ativ';
    protected $fillable = [
        'id',
        'grupo_id',
        'desc',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function grupo() {
        return $this->belongsTo('App\Grupo');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
