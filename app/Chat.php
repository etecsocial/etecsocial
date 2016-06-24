<?php

namespace App;

use App\Amizade;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

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
        'visto',
    ];

    public static function loadConversas()
    {
        return Mensagens::where(["id_destinatario" => auth()->user()->id])
            ->orWhere(["id_remetente" => auth()->user()->id])
            ->limit(15)
            ->get();
    }
    public static function loadMsgs($user_id)
    {
        return Mensagens::where(["id_remetente" => $user_id, "id_destinatario" => auth()->user()->id])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $user_id])
            ->limit(15)
            ->get();
    }

    public static function count()
    {
        return Mensagens::where(["id_destinatario" => auth()->user()->id, "visto" => 0])
            ->count();
    }

    public static function loadUsers($on = true)
    {
        return Amizade::where('user_id1', auth()->user()->id)
            ->where('aceitou', 1)
            ->where('online', $on)
            ->join('users', 'users.id', '=', 'amizades.user_id2')
            ->get();
    }

    public static function lastMsg($user_id)
    {
        $chat = Mensagens::where(["id_remetente" => $user_id, "id_destinatario" => auth()->user()->id])
            ->orWhere(["id_remetente" => auth()->user()->id, "id_destinatario" => $user_id])
            ->orderBy('data', 'desc')
            ->first();
        return isset($chat) ? $chat : false;
    }

}
