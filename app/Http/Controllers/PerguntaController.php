<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\ComentarioPergunta;
use App\Grupo;
use App\GrupoPergunta;
use App\Notificacao;
use Carbon\Carbon;

class PerguntaController extends Controller {

    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        Carbon::setLocale('pt_BR');
        if ($request->comentario == '') {
            return 'empty';
        }

        if (ComentarioPergunta::create([
                    'id_pergunta' => $request->id_pergunta,
                    'id_user' => Auth::user()->id,
                    'id_grupo' => $request->id_grupo,
                    'comentario' => $request->comentario
                ])) {
            if($this->notificaResposta($request->id_pergunta, $request->id_grupo)){
                return view('comentarioPergunta', [ 'id_pergunta' => $request->id_pergunta, 'id_comentario' => $request->id_comentario]);
            }
        }
    }

    public function notificaResposta($id_pergunta, $id_grupo) {
        if (!GrupoPergunta::where('id_autor', Auth::user()->id)->where('id', $id_pergunta)->first()) {
                $id_autor = GrupoPergunta::where('id_grupo', $id_grupo)->where('id', $id_pergunta)->first()->id;
                $texto = 'Respondeu à sua pergunta no grupo "' . Grupo::where('id_grupo', $id_grupo)->first()->nome . '"';

                if(Notificacao::create([
                    'id_rem' => Auth::user()->id,
                    'id_dest' => $id_autor->id_user,
                    'data' => Carbon::today()->timestamp,
                    'texto' => $texto])){
                    return true;
                }
                return;
        }
        return true;
    }

    public function destroy($id_comentario) {
        if (ComentarioPergunta::where('id', $id_comentario)->delete()) {
            return Response::json(['status' => true, 'id' => $id_comentario]);
        }
        return Response::json(['status' => false]);
    }
}