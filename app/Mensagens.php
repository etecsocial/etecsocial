<?php

namespace App;

use App\Amizade;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Mensagens extends Model
{

    protected $fillable = [
        'rem_idetente',
        'destinatario_id',
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
            'rem_idetente'    => auth()->user()->id,
            'destinatario_id' => $id_dest,
            'msg'             => $msg,
            'doc'             => isset($doc) ? $doc : null,
            'midia'           => isset($img) ? $img : null,
            'assunto'         => $assunto,
        ]);

    }

    public static function loadConversas()
    {
        return Mensagens::where(["destinatario_id" => auth()->user()->id])
            ->orWhere(["rem_idetente" => auth()->user()->id])
            ->limit(15)
            ->get();
    }

    public static function setRead($uid)
    {
        Mensagens::where(["destinatario_id" => auth()->user()->id, 'visto' => 0, 'rem_idetente' => $uid])
            ->update(['visto' => 1]);
    }

    public static function loadMsgs($uid)
    {
        Mensagens::setRead($uid);
        return Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
        //->limit(10)
            ->orderBy('created_at', 'asc')
            ->get();
    }
    public static function archiveMessage($id)
    {
        $rem = Mensagens::where("id", $id)->select(['rem_idetente'])->first();
        if ($rem->rem_idetente == auth()->user()->id) {
            return Mensagens::where("id", $id)->update(['arquivado_rem' => 1]);
        }return Mensagens::where("id", $id)->update(['arquivado_dest' => 1]);
    }
    public static function unArchiveMessage($id)
    {
        $rem = Mensagens::where("id", $id)->select(['rem_idetente'])->first();
        if ($rem->rem_idetente == auth()->user()->id) {
            return Mensagens::where("id", $id)->update(['arquivado_rem' => 0]);
        }return Mensagens::where("id", $id)->update(['arquivado_dest' => 0]);
    }
    public static function loadMsgsArchives($uid)
    {
        Mensagens::setRead($uid);
        return Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
        //->limit(10)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public static function countUnread()
    {
        return Mensagens::where(["destinatario_id" => auth()->user()->id, "visto" => 0])
            ->count();
    }

    public static function countMsgsTopic($uid)
    {
        $qtd = Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
            ->count();
        return ($qtd) ? ($qtd > 1 ? $qtd . ' mensagens' : '1 mensagem') : 'Sem mensagens';
    }
    public static function countMsgsTopicArchives($uid)
    {
        $qtd = Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
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
        return Mensagens::where(['mensagens.destinatario_id' => auth()->user()->id, 'mensagens.visto' => 0])
            ->join('users', 'users.id', '=', 'mensagens.rem_idetente')
            ->select(['users.id as id', 'users.name as nome'])
            ->orderBy('mensagens.created_at', 'desc')
            ->get();
    }

    public static function loadArchives()
    {
// @todo - otimizar os campos selecionados
        $array1 = Mensagens::where(['destinatario_id' => auth()->user()->id, 'copia_dest' => 1, 'arquivado_dest' => 1])
            ->join('users', 'users.id', '=', 'mensagens.rem_idetente')
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'desc')
            ->get();
        $array2 = Mensagens::where(['rem_idetente' => auth()->user()->id, 'copia_rem' => 1, 'arquivado_rem' => 1])
            ->join('users', 'users.id', '=', 'mensagens.destinatario_id')
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'desc')
            ->get();

        return ([$array1, $array2]);
    }

    public static function loadRecentes()
    {

        $array1 = Mensagens::where(['copia_dest' => 1, 'destinatario_id' => auth()->user()->id, 'arquivado_dest' => 0])
            ->where('rem_idetente', '<>', auth()->user()->id)
            ->join("users", 'users.id', '=', 'mensagens.rem_idetente')
        //->where('users.id', '!=', auth()->user()->id)
            ->groupBy('users.id')
            ->orderBy('mensagens.created_at', 'asc')
            ->get();
        $array2 = Mensagens::where(['copia_rem' => 1, 'rem_idetente' => auth()->user()->id, 'arquivado_rem' => 0])
            ->where('destinatario_id', '<>', auth()->user()->id)
            ->join("users", 'users.id', '=', 'mensagens.destinatario_id')
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
        $lastMsg = Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 0])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 0])
            ->orderBy('id', 'desc')
            ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }
    public static function lastMsgArchives($uid)
    {
        $lastMsg = Mensagens::where(["rem_idetente" => $uid, "destinatario_id" => auth()->user()->id, "copia_dest" => 1, 'arquivado_dest' => 1])
            ->orWhere(["rem_idetente" => auth()->user()->id, "destinatario_id" => $uid, "copia_rem" => 1, 'arquivado_rem' => 1])
            ->orderBy('id', 'desc')
            ->first();
        return isset($lastMsg) ? $lastMsg : false;
    }

}
