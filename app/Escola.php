<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $table = 'lista_etecs';
    
     protected $fillable = [
        'id_etc',
        'nome',
        'cod_prof'
    ];
}
