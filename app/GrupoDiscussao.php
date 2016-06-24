<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoDiscussao extends Model
{

    protected $table    = 'grupo_discussao';
    protected $fillable = [
        'id',
        'id_autor',
        'user_id',
        'assunto',
        'discussao',
        'id_grupo',
    ];

    public function getNumDiscussoes($id_grupo)
    {
        return GrupoDiscussao::where('id_grupo', $id_grupo)->count();
    }

}
