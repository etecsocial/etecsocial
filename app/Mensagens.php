<?php

namespace App;

use App\Amizade;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Mensagens extends Model
{

    protected $fillable = [
        'id_remetente',
        'id_destinatario',
        'msg',
        'assunto',
        'created_at',
        'data',
        'visto',
        'arquivado_dest',
        'arquivado_rem',
        'midia',
        'doc',
        'copia_dest',
        'copia_rem',
        'visto',
    ];

    public static function store($id_dest, $msg, $assunto, $doc, $img)
    {
        return Mensagens::create([
            'id_remetente'    => auth()->user()->id,
            'id_destinatario' => $id_dest,
            'msg'             => $msg,
            'doc'             => isset($doc) ? $doc : null,
            'midia'           => isset($img) ? $img : null,
            'assunto'         => $assunto,
        ]);

    }

    public static function loadConversas()
    {
        return Mensagens::where(["id_destinatario" => auth()->user()->id])
            ->orWhere(["id_remetente" => auth()->user()->id])
            ->limit(15)
            ->get();
    }

    public static function setRead($uid)
    {
        Mensagens::where(["id_destinatario" => auth()->user()->id, 'visto' => 0, 'id_remetente' => $uid])
            ->update(['visto' => 1]);
    }

    public static function loadMsgs($uid)
    {
        Mensagens::setRead($uid);
        return Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
        //->limit(10)
            ->orderBy('created_at', 'asc')
            ->get();
    }
    public static function archiveMessage($id)
    {
        $rem = Mensagens::where("id", $id)->select(['id_remetente'])->first();
        if ($rem->id_remetente == auth()->user()->id) {
            return Mensagens::where("id", $id)->update(['arquivado_rem' => 1]);
        }return Mensagens::where("id", $id)->update(['arquivado_dest' => 1]);
    }
    public static function unArchiveMessage($id)
    {
        $rem = Mensagens::where("id", $id)->select(['id_remetente'])->first();
        if ($rem->id_remetente == auth()->user()->id) {
            return Mensagens::where("id", $id)->update(['arquivado_rem' => 0]);
        }return Mensagens::where("id", $id)->update(['arquivado_dest' => 0]);
    }
    public static function loadMsgsArchives($uid)
    {
        Mensagens::setRead($uid);
        return Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
        //->limit(10)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public static function countUnread()
    {
        return Mensagens::where(["id_destinatario" => auth()->user()->id, "visto" => 0])
            ->count();
    }

    public static function countMsgsTopic($uid)
    {
        $qtd = Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
            ->count();
        return ($qtd) ? ($qtd > 1 ? $qtd . ' mensagens' : '1 mensagem') : 'Sem mensagens';
    }
    public static function countMsgsTopicArchives($uid)
    {
        $qtd = Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
            ->count();
        return ($qtd) ? ($qtd > 1 ? $qtd . ' mensagens' : '1 mensagem') : 'Sem mensagens';
    }

    public static function loadFriends()
    {
// @todo - otimizar os campos selecionados
        return Amizade::where('user_id1', auth()->user()->id)
            ->where('aceitou', 1)
            ->where('user_id2', '!=', auth()->user()->id)
            ->join('users', 'users.id', '=', 'amizades.user_id2')
            ->get();
    }

    public static function loadUnreads()
    {
// @todo - otimizar os campos selecionados
        return Mensagens::where(['mensagens.id_destinatario' => auth()->user()->id, 'mensagens.visto' => 0])
            ->join('users', 'users.id', '=', 'mensagens.id_remetente')
            ->select(['users.id as id', 'users.name as nome'])
            ->orderBy('mensagens.created_at', 'desc')
            ->get();
    }

    public static function loadArchives()
    {
// @todo - otimizar os campos selecionados
        $array1 = Mensagens::where(['id_destinatario' => auth()->user()->id, 'copia_dest' => 1, 'arquivado_dest' => 1])
            ->join('users', 'users.id', '=', 'mensagens.id_remetente')
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'desc')
            ->get();
        $array2 = Mensagens::where(['id_remetente' => auth()->user()->id, 'copia_rem' => 1, 'arquivado_rem' => 1])
            ->join('users', 'users.id', '=', 'mensagens.id_destinatario')
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'desc')
            ->get();

        return ([$array1, $array2]);
    }

    public static function loadRecentes()
    {

        $array1 = Mensagens::where(['copia_dest' => 1, 'id_destinatario' => auth()->user()->id, 'arquivado_dest' => 0])
            ->where('id_remetente', '<>', auth()->user()->id)
            ->join("users", 'users.id', '=', 'mensagens.id_remetente')
        //->where('users.id', '!=', auth()->user()->id)
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'asc')
            ->get();
        $array2 = Mensagens::where(['copia_rem' => 1, 'id_remetente' => auth()->user()->id, 'arquivado_rem' => 0])
            ->where('id_destinatario', '<>', auth()->user()->id)
            ->join("users", 'users.id', '=', 'mensagens.id_destinatario')
        //->where('users.id', '!=', auth()->user()->id)
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'asc')
            ->get();
        return ([$array1, $array2]);
    }

    public static function loadTurma()
    {
        return User::join('', auth()->user()->id)
            ->where('aceitou', 1)
            ->where('user_id2', '!=', auth()->user()->id)
            ->join('users', 'users.id', '=', 'amizades.user_id2')
            ->get();
    }

    public static function lastMsg($uid)
    {
        $lastMsg = Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
            ->orderBy('id', 'desc')
            ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }
    public static function lastMsgArchives($uid)
    {
        $lastMsg = Mensagens::where(["id_remetente" => $uid, "id_destinatario" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
            ->orderBy('id', 'desc')
            ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }

}
