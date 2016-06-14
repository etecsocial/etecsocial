<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Controllers\Controller;
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
            'id_remetente'    => auth()->user()->id,
            'id_destinatario' => $request->id,
            'msg'             => $request->msg,
            'data'            => $time,
        ]);
        
        Event::fire(new MensagemChat($request->id, auth()->user()->id, $request->msg, $time));
    }

    public function abrir(Request $request)
    {

        if ($request->data) {

            $msgs = Chat::where(['id_remetente' => $request->id_user, 'id_destinatario' => auth()->user()->id])
                ->orWhere(['id_remetente' => auth()->user()->id, 'id_destinatario' => $request->id_user])
                ->where('data', '<', $request->data)
                ->orderBy('data', 'desc')
                ->limit(15)
                ->get()
                ->toArray();
        } else {

            $msgs = Chat::where(['id_remetente' => $request->id_user, 'id_destinatario' => auth()->user()->id])
                ->orWhere(['id_remetente' => auth()->user()->id, 'id_destinatario' => $request->id_user])
                ->orderBy('data', 'desc')
                ->limit(15)
                ->get()
                ->toArray();
        }

        return view('chat.msgs', ['msgs' => $msgs, 'id_user' => $request->id_user]);
    }

   
}
