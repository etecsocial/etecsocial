<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

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
        'id_modulo'
    ];
    
    public static function loada() {
        $age = Agenda::where('id_user', Auth::user()->id)
                ->where('start', '>', time())
                ->get();
        
         if(empty($age[0])) {
            return false;
        }
        
        return $age;
    }
}
