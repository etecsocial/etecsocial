<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amizade extends Model {

    protected $fillable = [
        'id_user1',
        'id_user2',
        'aceitou',
    ];
    
    
    
    //@todo ver como deve ficar o Eloquent neste caso!!
    

    public static function verificar($id) {
        $amizade1 = Amizade::where([
                    'id_user1' => auth()->user()->id,
                    'id_user2' => $id,
        ]);

        if ($amizade1->count()) {
            if ($amizade1->first()->aceitou) {
                return ['status' => true];
            } else {
                return ['status' => false, 'error' => 'NAO_ACEITOU'];
            }
        }

        $amizade2 = Amizade::where([
                    'id_user1' => $id,
                    'id_user2' => auth()->user()->id,
        ]);

        if ($amizade2->count()) {
            return ['status' => false, 'error' => 'VOCE_NAO_ACEITOU'];
        } else {
            return ['status' => false, 'error' => 'NAO_AMIGO'];
        }
    }

    public static function novo($id) {
        Amizade::create([
            "id_user1" => auth()->user()->id,
            "id_user2" => $id,
        ]);
    }

    public static function aceitar($id) {
        Amizade::where([
            'id_user1' => $id,
            'id_user2' => auth()->user()->id,
        ])->update(['aceitou' => 1]);

        Amizade::create([
            "id_user1" => auth()->user()->id,
            "id_user2" => $id,
            "aceitou" => 1,
        ]);

        Notificacao::create([
            'id_rem' => auth()->user()->id,
            'id_dest' => $id,
            'data' => time(),
            'texto' => "Aceitou sua solicitação",
        ]);
    }

    public static function recusar($id) {
        Amizade::where([
            'id_user1' => $id,
            'id_user2' => auth()->user()->id,
        ])->delete();
    }

    public static function desfazer($id) {
        Amizade::where([
            'id_user1' => auth()->user()->id,
            'id_user2' => $id,
        ])->orWhere([
            'id_user1' => $id,
            'id_user2' => auth()->user()->id,
        ])->delete();
    }

    public static function carrega() {
        $migos = Amizade::where([
                    'id_user2' => auth()->user()->id,
                    'aceitou' => 0,
                ])->limit(5)->get();

        if (empty($migos[0])) {
            return false;
        }

        return $migos;
    }

    public static function count() {
        $migos = Amizade::where([
                    'id_user2' => auth()->user()->id,
                    'aceitou' => 0,
                ])->count();

        return $migos;
    }

}
