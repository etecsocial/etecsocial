<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Amizade;
use App\User;

class Mensagens extends Model {

    protected $fillable = [
        'id_remetente',
        'id_destinatario',
        'msg',
        'assunto',
        'created_at',
        'data',
        'visto',
        'arquivado',
        'video',
        'img',
        'doc',
        'copia_dest',
        'copia_rem',
        'visto'
    ];

    public static function store($id_dest, $msg, $assunto) {
        return Mensagens::create([
                    'id_remetente' => auth()->user()->id,
                    'id_destinatario' => $id_dest,
                    'msg' => $msg,
                    'assunto' => $assunto
        ]);
    }

    public static function loadConversas() {
        return Mensagens::where(["id_destinatario" => auth()->user()->id])
                        ->orWhere([ "id_remetente" => auth()->user()->id])
                        ->limit(15)
                        ->get();
    }

    public static function setRead($uid) {
        Mensagens::where(["id_destinatario" => auth()->user()->id, 'visto' => 0, 'id_remetente' => $uid])
                ->update(['visto' => 1]);
    }

    public static function loadMsgs($uid) {
        Mensagens::setRead($uid);
        return Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1])
                        ->orWhere([ "id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                        //->limit(10)
                        ->orderBy('created_at', 'asc')
                        ->get();
    }

    public static function countUnread() {
        return Mensagens::where([ "id_destinatario" => auth()->user()->id, "visto" => 0])
                        ->count();
    }

    public static function countMsgsTopic($uid) {
        $qtd = Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1])
                ->orWhere([ "id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                ->count();
        return ($qtd) ? ($qtd > 1 ? $qtd . ' mensagens' : '1 mensagem') : 'Sem mensagens';
    }

    public static function loadFriends() {// @todo - otimizar os campos selecionados
        return Amizade::where('id_user1', auth()->user()->id)
                        ->where('aceitou', 1)
                        ->where('id_user2', '!=', auth()->user()->id)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }
    
    public static function loadUnreads() {// @todo - otimizar os campos selecionados
        return Mensagens::where(['mensagens.id_destinatario' => auth()->user()->id, 'mensagens.visto' => 0])
                ->join('users', 'users.id', '=', 'mensagens.id_remetente' )
                ->select(['users.id as id', 'users.nome as nome'])
                ->orderBy('mensagens.created_at', 'desc')
                ->get();
    }

    public static function loadRecentes() {
        
        //tem que dar um jeito de juntar esses dois selects em um, por enquanto usarei o de cima
          $array1 = Mensagens::where(['copia_dest' => 1, 'id_destinatario' => auth()->user()->id])
                ->join("users", 'users.id', '=', 'mensagens.id_remetente')
                //->where('users.id', '!=', auth()->user()->id)
                ->groupBy('users.id')
                ->orderBy('mensagens.created_at', 'asc')
                ->get();
          $array2 = Mensagens::where(['copia_rem' => 1, 'id_remetente' => auth()->user()->id])
                ->join("users", 'users.id', '=', 'mensagens.id_destinatario')
                //->where('users.id', '!=', auth()->user()->id)
                ->groupBy('users.id')
                ->orderBy('mensagens.created_at', 'asc')
                ->get();
            return ($array2);
    }

    public static function loadTurma() {
        return User::join('', auth()->user()->id)
                        ->where('aceitou', 1)
                        ->where('id_user2', '!=', auth()->user()->id)
                        ->join('users', 'users.id', '=', 'amizades.id_user2')
                        ->get();
    }

    public static function lastMsg($uid) {
        $lastMsg = Mensagens::where([ "id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1])
                ->orWhere([ "id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1])
                ->orderBy('id', 'desc')
                ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }

}
