<?php

namespace App\Http\Controllers;

use App\ComentarioDiscussao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class DiscussaoController extends Controller
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
//ARRUAR ISSO - VALIDATE
        ComentarioDiscussao::create([
            'discussao_id' => $request->discussao_id,
            'user_id' => auth()->user()->id,
            'grupo_id' => $request->grupo_id,
            'comentario' => $request->comentario,
        ]);

        return view('comentarios.discussao', ['discussao_id' => $request->discussao_id, 'comentario_id' => $request->comentario_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($comentario_id)
    {
        Carbon::setLocale('pt_BR');
        if (ComentarioDiscussao::where('id', $comentario_id)->delete()) {
            return Response::json(['status' => true, 'id' => $comentario_id]);
        }

        return Response::json(['status' => false]);
    }
}
