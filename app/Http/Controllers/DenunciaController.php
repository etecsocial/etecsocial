<?php

namespace App\Http\Controllers;

use App\DenunciaGrupo;
use App\GrupoDiscussao;
use App\GrupoPergunta;
use App\GrupoUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class DenunciaController extends Controller
{
    /**
     * Classe de denúncia, cria, avalia e faz controle das publicações.
     */
    public function createDenunciaGrupo(Request $request)
    {
        Carbon::setLocale('pt_BR');
        if (!DenunciaGrupo::where('grupo_id', $request->grupo_id)->where('tipo', $request->tipo_pub)->where('denuncia', $request->motivo)->where('autor_id_denuncia', auth()->user()->id)->first()) {
            $denuncia = new DenunciaGrupo();
            $denuncia->id_pub = $request->id_pub;
            $denuncia->tipo = $request->tipo_pub;
            $denuncia->denuncia = $request->motivo;
            $denuncia->grupo_id = $request->grupo_id;
            $denuncia->autor_id_denuncia = auth()->user()->id;
            $denuncia->autor_id_pub = $request->autor_id_pub;
            $denuncia->data = Carbon::today();
            if ($denuncia->save()) {
                return Response::json(['response' => 1]);
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function analisaDenunciaGrupo(Request $request)
    {
        if ($request->resposta == 1) {
            if ($request->tipo_pub == 'discussao') {
                $a = GrupoDiscussao::where('grupo_id', $request->grupo_id)->where('id', $request->id_pub)->delete();
            } elseif ($request->tipo_pub == 'pergunta') {
                $a = GrupoPergunta::where('grupo_id', $request->grupo_id)->where('id', $request->id_pub)->delete();
            }
        }

        if ($request->banir) {
            GrupoUser::where('grupo_id', $request->grupo_id)
                ->where('user_id', $request->autor_id_pub)
                ->update(array('is_banido' => 1));
        }

        if (DenunciaGrupo::where('id_pub', $request->id_pub)
            ->where('grupo_id', $request->grupo_id)
            ->where('tipo', $request->tipo_pub)
            ->update(array('visto' => 1))) {
            if (isset($a)) {
                return Response::json(['response' => 1, 'id' => $request->id_pub, 'tipo' => $request->tipo_pub, 'user_id' => $request->autor_id_pub]);
            }

            return Response::json(['response' => 1]);
        }

        return Response::json(['response' => 2]);
    }

//    public function store(Request $request) {
    //        Carbon::setLocale('pt_BR');
    //        $this->validate($request, [ 'publicacao' => 'required']);
    //
    //        $msg = "Olá professor(a), recebemos uma denuncia de uma" . $request->post_id ? 'publicação' : 'mensagem' . ' e gos'
    //                . 'taría-mos que você desse uma olhada.'
    //                . 'Segundo o autor da denúncia, o conteúdo não deveria estar na ETEC Social, por conter'
    //                . $request->denuncia . '. Veja abaixo o conteúdo da' . $request->post_id ? 'publicação' : 'mensagem' . ':';
    //
    //        $denuncia = new Denuncia;
    //        $denuncia->id_usuario = auth()->user()->id;
    //        $request->post_id ? $denuncia->publicacao = $request->post_id : $denuncia->mensagem_id = $request->mensagem_id;
    //        $denuncia->data = Carbon::parse(Carbon::today())->format("Y-m-d");
    //        $denuncia->denuncia = $msg;
    //        $denuncia->tipo = $request->denuncia;
    //        return $denuncia->save() ? Response::json([ "status" => true]) : Response::json([ "status" => false]);
    //    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function getDenunciasGrupo(Request $request)
    {
        return DenunciaGrupo::where('grupo_id', $request->grupo_id)
            ->where('visto', 0)
            ->orderBy('created_at', 'desc')
            ->save();
    }
}
