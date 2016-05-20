<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description',
        'start',
        'end',
        'id_user',
        'is_publico',
        'id_turma',
    ];
    
    public static function loada() {
        $age = Agenda::where('id_user', auth()->user()->id)->where('start', '>', time())->get()->first();

        return (empty($age)) ? false : $age;
    }
}