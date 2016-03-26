<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Amizade;

class Mensagens extends Model {

    protected $fillable = [
        'id_remetente',
        'id_destinatario',
        'msg',
        'assunto',
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

    public static function store($id_dest, $msg, $assunto) {
        return Mensagens::create([
            'id_remetente' => Auth::user()->id,
            'id_destinatario' => $id_dest,
            'msg' => $msg,
            'assunto' => $assunto
        ]);
    }

    public static function loadConversas() {
        return Mensagens::where(["id_destinatario" => Auth::user()->id])
                        ->orWhere([ "id_remetente" => Auth::user()->id])
                        ->limit(15)
                        ->get();
    }

    public static function loadMsgs($uid) {
        return Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => Auth::user()->id, "copia_dest" => 1])
                        ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                        ->limit(10)
                        ->get();
    }

    public static function countUnread() {
        return Mensagens::where([ "id_destinatario" => Auth::user()->id, "visto" => 0])
                        ->count();
    }
    public static function countMsgsTopic($uid) {
        $qtd = Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => Auth::user()->id, "copia_dest" => 1])
                            ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                            ->count();
        return ($qtd) ? ($qtd > 1 ? $qtd.' mensagens' : '1 mensagem') : 'Sem mensagens';
    }

    public static function loadUsers() {
        return Amizade::where('id_user1', Auth::user()->id)
                        ->where('aceitou', 1)
                        ->where('id_user2', '!=', Auth::user()->id)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }
    public static function loadTurma() {
        return User::join('', Auth::user()->id)
                        ->where('aceitou', 1)
                        ->where('id_user2', '!=', Auth::user()->id)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }

    public static function lastMsg($uid) {
        $lastMsg = Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => Auth::user()->id, "copia_dest" => 1])
                            ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                            ->orderBy('id', 'desc')
                            ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }

}
