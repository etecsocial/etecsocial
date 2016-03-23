<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Amizade;

class Chat extends Model {

    protected $fillable = [
        'id_remetente',
        'id_destinatario',
        'msg',
        'created_at',
        'data',
        'visto',
        'video',
        'img',
        'doc',
        'copia_dest',
        'copia_rem',
        'visto'
    ];

    public static function loadConversas() {
        return Mensagens::where(["id_destinatario" => Auth::user()->id])
                        ->orWhere([ "id_remetente" => Auth::user()->id])
                        ->limit(15)
                        ->get();
    }
    public static function loadMsgs($id_user) {
        return Mensagens::where([ "id_remetente" => $id_user, "id_destinatario" => Auth::user()->id])
                        ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $id_user])
                        ->limit(15)
                        ->get();
    }

    public static function count() {
        return Mensagens::where([ "id_destinatario" => Auth::user()->id, "visto" => 0])
                        ->count();
    }

    public static function loadUsers($on = true) {
        return Amizade::where('id_user1', Auth::user()->id)
                        ->where('aceitou', 1)
                        ->where('online', $on)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }

    public static function lastMsg($id_user) {
        $chat = Mensagens::where([ "id_remetente" => $id_user, "id_destinatario" => Auth::user()->id])
                ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $id_user])
                ->orderBy('data', 'desc')
                ->first();
        return isset($chat) ? $chat : false;
    }

}
