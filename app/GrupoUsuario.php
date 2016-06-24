<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoUsuario extends Model
{

    protected $table = 'grupo_usuario';

    protected $fillable = [
        'id_grupo',
        'user_id',
        'is_admin',
        'is_banido',
    ];

}
