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
        Mensagens::create([
            'id_remetente' => Auth::user()->id,
            'id_destinatario' => $id_dest,
            'msg' => $msg,
            'assunto' => $assunto
        ]);
    }

    public static function loadConversas() {
        return Mensagens::where(["id_destinatario" => Auth::user()->id])
                        ->orWhere([ "id_remetente" => Auth::user()->id])
                        ->select('mensagens.id', 'mensagens.id_destinatario', 'mensagens.id_remetente', 'mensagens.msg', 'mensagens.data', 'mensagens.visto', 'mensagens.doc', 'mensagens.video', 'mensagens.img')
                        ->limit(15)
                        ->get();
    }

    public static function loadMsgs($id_user) {
        return Mensagens::where([ "id_remetente" => $id_user, "id_destinatario" => Auth::user()->id])
                        ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $id_user])
                        ->limit(10)
                        ->get();
    }

    public static function count() {
        return Mensagens::where([ "id_destinatario" => Auth::user()->id, "visto" => 0])
                        ->count();
    }

    public static function loadUsers() {
        return Amizade::where('id_user1', Auth::user()->id)
                        ->where('aceitou', 1)
                        ->where('id_user2', '!=', Auth::user()->id)
                        //->where('online', $on)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }

    public static function lastMsg($id_user) {
        $chat = Mensagens::where([ "id_remetente" => Auth::user()->id, "id_destinatario" => $id_user])
                ->orWhere([ "id_remetente" => $id_user, "id_destinatario" => Auth::user()->id])
                ->orderBy('id', 'desc')
                //->select('id')
                ->first();
        return isset($chat) ? $chat : false;
    }

}
