<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\ComentarioDiscussao;
use App\Notificacao;
use Carbon\Carbon;

class DiscussaoController extends Controller {
    
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

        ComentarioDiscussao::create([
            'id_discussao' => $request->id_discussao,
            'id_user' => Auth::user()->id,
            'id_grupo' => $request->id_grupo,
            'comentario' => $request->comentario
        ]);

        return view('comentarioDiscussao', ['id_discussao' => $request->id_discussao, 'id_comentario' => $request->id_comentario]);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id_comentario) {
        Carbon::setLocale('pt_BR');
        if(ComentarioDiscussao::where('id', $id_comentario)->delete()){
            return Response::json(['status' => true, 'id' => $id_comentario]);
        }
        return Response::json(['status' => false]);
    }
}
