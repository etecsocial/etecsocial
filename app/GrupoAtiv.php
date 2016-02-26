<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoAtiv extends Model {

    protected $table = 'grupo_ativ';
    protected $fillable = [
        'id',
        'id_grupo',
        'desc',
        'created_at',
        'updated_at'
    ];
}
