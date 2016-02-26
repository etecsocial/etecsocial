<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use DB;
use Auth;
use App\DenunciaGrupo;
use App\GrupoPergunta;
use App\GrupoUsuario;
use App\GrupoDiscussao;
use App\User;
use App\Post;
use Carbon\Carbon;

class DenunciaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Classe de denúncia, cria, avalia e faz controle das publicações.
     *
     */
    public function createDenunciaGrupo(Request $request) {
        Carbon::setLocale('pt_BR');
        if (!DenunciaGrupo::where('id_grupo', $request->id_grupo)->where('tipo', $request->tipo_pub)->where('denuncia', $request->motivo)->where('id_autor_denuncia', Auth::user()->id)->first()) {
            $denuncia = new DenunciaGrupo;
            $denuncia->id_pub = $request->id_pub;
            $denuncia->tipo = $request->tipo_pub;
            $denuncia->denuncia = $request->motivo;
            $denuncia->id_grupo = $request->id_grupo;
            $denuncia->id_autor_denuncia = Auth::user()->id;
            $denuncia->id_autor_pub = $request->id_autor_pub;
            $denuncia->data = \Carbon\Carbon::today();
            if ($denuncia->save()) {
                return Response::json([ "response" => 1]);
            }return Response::json([ "response" => 2]);
        }return Response::json([ "response" => 3]);
    }

    public function analisaDenunciaGrupo(Request $request) {
        if ($request->resposta == 1) {
            if ($request->tipo_pub == 'discussao') {
                $a = GrupoDiscussao::where('id_grupo', $request->id_grupo)->where('id', $request->id_pub)->delete();
            } elseif ($request->tipo_pub == 'pergunta') {
                $a = GrupoPergunta::where('id_grupo', $request->id_grupo)->where('id', $request->id_pub)->delete();
            }
            if (isset($a)) {
                DB::table('grupo')
                        ->where('id', $request->id_grupo)
                        ->decrement('num_participantes');
            }
        }

        if ($request->banir) {
            GrupoUsuario::where('id_grupo', $request->id_grupo)
                    ->where('id_user', $request->id_autor_pub)
                    ->update(array('is_banido' => 1));
        }

        if (DenunciaGrupo::where('id_pub', $request->id_pub)
                        ->where('id_grupo', $request->id_grupo)
                        ->where('tipo', $request->tipo_pub)
                        ->update(array('visto' => 1))) {
            if (isset($a)) {
                return Response::json([ "response" => 1, "id" => $request->id_pub, "tipo" => $request->tipo_pub, "id_user" => $request->id_autor_pub]);
            }return Response::json([ "response" => 1]);
        }return Response::json([ "response" => 2]);
    }

//    public function store(Request $request) {
//        Carbon::setLocale('pt_BR');
//        $this->validate($request, [ 'publicacao' => 'required']);
//
//        $msg = "Olá professor(a), recebemos uma denuncia de uma" . $request->id_post ? 'publicação' : 'mensagem' . ' e gos'
//                . 'taría-mos que você desse uma olhada.'
//                . 'Segundo o autor da denúncia, o conteúdo não deveria estar na ETEC Social, por conter'
//                . $request->denuncia . '. Veja abaixo o conteúdo da' . $request->id_post ? 'publicação' : 'mensagem' . ':';
//
//        $denuncia = new Denuncia;
//        $denuncia->id_usuario = Auth::user()->id;
//        $request->id_post ? $denuncia->publicacao = $request->id_post : $denuncia->id_mensagem = $request->id_mensagem;
//        $denuncia->data = Carbon::parse(Carbon::today())->format("Y-m-d");
//        $denuncia->denuncia = $msg;
//        $denuncia->tipo = $request->denuncia;
//        return $denuncia->save() ? Response::json([ "status" => true]) : Response::json([ "status" => false]);
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDenunciasGrupo(Request $request) {
        return DenunciaGrupo::where('id_grupo', $request->id_grupo)
                        ->where('visto', 0)
                        ->orderBy('created_at', 'desc')
                        ->save();
    }

}
