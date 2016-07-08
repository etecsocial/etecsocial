<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoUser extends Model
{

    protected $table = 'grupo_user';

    protected $fillable = [
        'grupo_id',
        'user_id',
        'is_admin',
        'is_banido',
    ];

}
