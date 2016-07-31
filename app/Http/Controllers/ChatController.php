<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Event;
use App\Events\MensagemChat;

class ChatController extends Controller
{
    public function pagina()
    {
        return view('chat.pagina');
    }

    public function enviar(Request $request)
    {
        $time = time();

        Chat::create([
            'remetente_id' => auth()->user()->id,
            'destinatario_id' => $request->id,
            'msg' => $request->msg,
            'data' => $time,
        ]);

        Event::fire(new MensagemChat($request->id, auth()->user()->id, $request->msg, $time));
    }

    public function abrir(Request $request)
    {
        if ($request->data) {
            $msgs = Chat::where(['remetente_id' => $request->user_id, 'destinatario_id' => auth()->user()->id])
                ->orWhere(['remetente_id' => auth()->user()->id, 'destinatario_id' => $request->user_id])
                ->where('data', '<', $request->data)
                ->orderBy('data', 'desc')
                ->limit(15)
                ->get()
                ->toArray();
        } else {
            $msgs = Chat::where(['remetente_id' => $request->user_id, 'destinatario_id' => auth()->user()->id])
                ->orWhere(['remetente_id' => auth()->user()->id, 'destinatario_id' => $request->user_id])
                ->orderBy('data', 'desc')
                ->limit(15)
                ->get()
                ->toArray();
        }

        return view('chat.msgs', ['msgs' => $msgs, 'user_id' => $request->user_id]);
    }
}
