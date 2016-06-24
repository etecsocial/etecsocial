<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $fillable = [
        'id_dest',
        'rem_id',
        'data',
        'visto',
        'texto',
        'is_post',
        'action',
    ];

    public static function carrega()
    {
        $not = Notificacao::where('id_dest', auth()->user()->id)->orderBy('data', 'desc')->limit(5)->get();

        if (empty($not[0])) {
            return false;
        }

        return $not;
    }

    public static function count()
    {
        return Notificacao::where(['id_dest' => auth()->user()->id, 'visto' => 0])->orderBy('data', 'desc')->count();
    }
}
