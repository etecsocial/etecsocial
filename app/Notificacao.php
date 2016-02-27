<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Notificacao extends Model
{
     protected $fillable = [
        'id_dest',
        'id_rem',
        'data',
        'visto',
        'texto',
        'is_post',
        'action'
    ];
     
     public static function carrega() {
        $not = Notificacao::where('id_dest', Auth::user()->id)->orderBy('data', 'desc')->limit(5)->get();
        
         if(empty($not[0])) {
            return false;
        }
        
        return $not;
     }
     
     public static function count() {
        return Notificacao::where([ 'id_dest' => Auth::user()->id, 'visto' => 0 ])->orderBy('data', 'desc')->count();
     }
}