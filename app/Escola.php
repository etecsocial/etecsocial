<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $table = 'escolas';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'nome',
        'cod_prof',
    ];
}
