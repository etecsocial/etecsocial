<?php

namespace App\Http\Controllers;

use App\ComentarioPergunta;
use App\Grupo;
use App\GrupoPergunta;
use App\Http\Controllers\Controller;
use App\Notificacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class PerguntaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Carbon::setLocale('pt_BR');
        if ($request->comentario == '') {
            return 'empty';
        }

        if (ComentarioPergunta::create([
            'id_pergunta' => $request->id_pergunta,
            'user_id'     => auth()->user()->id,
            'grupo_id'    => $request->grupo_id,
            'comentario'  => $request->comentario,
        ])) {
            if ($this->notificaResposta($request->id_pergunta, $request->grupo_id)) {
                return view('comentarios.pergunta', ['id_pergunta' => $request->id_pergunta, 'comentario_id' => $request->comentario_id]);
            }
        }
    }

    public function notificaResposta($id_pergunta, $grupo_id)
    {
        if (!GrupoPergunta::where('autor_id', auth()->user()->id)->where('id', $id_pergunta)->first()) {
            $autor_id = GrupoPergunta::where('grupo_id', $grupo_id)->where('id', $id_pergunta)->first()->id;
            $texto    = 'Respondeu à sua pergunta no grupo "' . Grupo::where('grupo_id', $grupo_id)->first()->nome . '"';

            if (Notificacao::create([
                'rem_id'  => auth()->user()->id,
                'id_dest' => $autor_id->user_id,
                'data'    => Carbon::today()->timestamp,
                'texto'   => $texto])) {
                return true;
            }
            return;
        }
        return true;
    }

    public function destroy($comentario_id)
    {
        if (ComentarioPergunta::where('id', $comentario_id)->delete()) {
            return Response::json(['status' => true, 'id' => $comentario_id]);
        }
        return Response::json(['status' => false]);
    }
}
