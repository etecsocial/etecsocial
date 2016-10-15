<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\GrupoAtiv;
use App\GrupoDiscussao;
use App\GrupoMaterial;
use App\GrupoPergunta;
use App\GrupoUser;
use App\Notificacao;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;

class GrupoController extends Controller
{
    /**
     * Classe controladora de grupos de estudo.
     *
     * @2015 ETEC Social.
     */
    public $extensionMidia = ['flv', 'FLV', 'mp4', 'MP4', 'jpg', 'JPG', 'png', 'PNG', 'gif'];
    public $extensionDocs = ['pdf', 'txt', 'doc', 'docx', 'pptx', 'xls'];
    public $MidiaDestinationPath = 'midia/grupos';
    public $DocsDestinationPath = 'docs/grupos';

    public function listar()
    {
        $grupos = auth()->user()->grupos;
        //@TODO nao deixar peggar caso seja banido

        $amigos = User::join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('users.id', '!=', auth()->user()->id)
                ->select(['users.id', 'users.name'])
                ->where('amizades.user_id2', auth()->user()->id)
                ->get();

        $professores = auth()->user()->professores();

        return view('grupo.lista', ['grupos' => $grupos, 'amigos' => $amigos, 'professores' => $professores]);
    }

    public function index($groupname)
    {
        Carbon::setLocale('pt_BR');
        $grupo = Grupo::where('url', $groupname)->firstOrFail();
        // Verifica se o grupo existe && Verifica se é expirado
            if (($grupo->expiracao > Carbon::today()) || ($grupo->expiracao == null)) {
                if (auth()->user()->grupos()->where('grupo.id', $grupo->id)->where('is_banido', 0)->first()) { // Verifica se o usuário é integrante e não está banido
                    return view('grupo.home', $this->getGroupData($grupo));
                } elseif (auth()->user()->grupos()->where('grupo.id', $grupo->id)->where('is_banido', 1)->first()) { // Verifica se o usuário é banido, já que a seleção anterior falhou
                    return view('grupo.home', $this->getGroupDataBan($grupo)); // Retorna a view com os dados
                }
            } else { // O grupo expirou
                if (auth()->user()->grupos()->where('grupo.id', $grupo->id)->where('is_banido', 0)->first()) {
                    return view('grupo.home', $dados = $this->getGroupDataExp($grupo));
                } elseif (auth()->user()->grupos()->where('grupo.id', $grupo->id)->where('is_banido', 1)->first()) {
                    return view('grupo.home', $this->getGroupDataBan($grupo));
                }
            }
    }

    /**
     * Cria grupo de estudos.
     * Requests - nome, url, assunto, expiracao.
     */
    public function criar(Request $request)
    {
        if (($request->nome) and ($request->assunto)) {
            if ($request->url and (Grupo::where('url', $request->url)->count())) {
                return Response::json(['status' => 3]);
            }
            if ($request->expiracao and $request->expiracao >= Carbon::today()) {
                $exp = $request->expiracao;
            } elseif ($request->expiracao) {
                return Response::json(['status' => 2]);
            }
            $g = Grupo::create([
                        'nome' => $request->nome,
                        'assunto' => $request->assunto,
                        'url' => $request->url ? $request->url : Grupo::makeUrl($request->nome),
                        'materia' => $request->materia,
                        'id_criador' => auth()->user()->id,
                        'expiracao' => isset($exp) ? $exp : null,
            ]);

            return Response::json(['status' => 1, 'nome' => $g->nome, 'url' => $g->url]);
        }

        return Response::json(['status' => 4]);
    }

    /**
     * Adiciona aluno ao grupo, chamada quando utilizada uma modal.
     * Variáveis - grupo_id, alunos.
     */
    public function addAluno($grupo_id, $alunos)
    {
        foreach ($alunos as $aluno) {
            GrupoUser::create([
                'grupo_id' => $grupo_id,
                'user_id' => $aluno,
            ]);
        }
    }

    /**
     * Adiciona aluno ao grupo, chamada por AJAX.
     * Requests - grupo_id, alunos.
     * Falta notificar admin que o aluno entrou
     * EDITADO.
     */
    public function addAlunoDir(Request $request)
    {
        if (!GrupoUser::where('grupo_id', $request->grupo_id)->where('user_id', $request->id_amigo)->first()) {
            if (GrupoUser::create([
                        'grupo_id' => $request->grupo_id,
                        'user_id' => $request->id_amigo,
                    ])) {
                Notificacao::create([
                    'rem_id' => auth()->user()->id,
                    'id_dest' => $request->id_amigo,
                    'data' => time(),
                    'texto' => "Adicionou você ao grupo '".Grupo::verGrupo($request->grupo_id)->nome."'",
                    'is_post' => false,
                    'action' => '/grupo/'.Grupo::verGrupo($request->grupo_id)->url,
                ]);

                return Response::json(['response' => 1]);
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

//    public function addProfDir(Request $request) { //CRIA A NOTIFICAÇÃO PARA O PROFESSOR
    //        $add = new GrupoUser;
    //        $add->grupo_id = $request->grupo_id;
    //        $add->user_id = $request->id_prof;
    //        if ($add->save()) {
    //            $this->IncParticipante($request->grupo_id);
    //            return Response::json([ 'response' => 1]);
    //        }return Response::json([ 'response' => 0]);
    //    }

    public function addProfGrupo(Request $request)
    {
        //SALVA NO DB APÓS CONFIRMAÇÃO (ou nao)
        if (!GrupoUser::where('user_id', $request->id_professor)->where('grupo_id', $request->grupo_id)->first()) {
            return GrupoUser::create([
                        'grupo_id' => $request->grupo_id,
                        'user_id' => $request->id_professor,
                    ]) ? Response::json(['response' => 1]) : Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function removeAlunoGrupo(Request $request)
    {
        // Remove o aluno do grupo
        if (GrupoUser::where('user_id', $request->id_aluno)->where('grupo_id', $request->grupo_id)->first()) {
            if (GrupoUser::where('user_id', $request->id_aluno)
                            ->where('grupo_id', $request->grupo_id)
                            ->update(array('is_banido' => 1))) {
                Notificacao::create([
                    'rem_id' => $request->id_aluno,
                    'id_dest' => $request->id_aluno,
                    'data' => time(),
                    'texto' => 'Você foi banido do grupo "'.Grupo::verGrupo($request->grupo_id)->nome.'" pelo administrador.',
                    'is_post' => false,
                    'action' => '/grupo/'.Grupo::verGrupo($request->grupo_id)->url,
                ]);

                return Response::json(['response' => 1]);
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function setDisc(Request $request)
    {
        $this->validate($request, ['assunto' => 'required']);
        $this->validate($request, ['discussao' => 'required']);

        $disc = GrupoDiscussao::create([
                    'grupo_id' => $request->idgrupo,
                    'titulo' => $request->titulo ? $request->titulo : 'Sem título',
                    'autor_id' => auth()->user()->id,
                    'assunto' => $request->assunto,
                    'discussao' => $request->discussao,
        ]);

        $this->setAtiv($request->idgrupo, null, 'discussao', Carbon::now(), auth()->user()->id);

        $id_dests = GrupoUser::where('grupo_id', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
        foreach ($id_dests as $id_dest) {
            Notificacao::create([
                'rem_id' => auth()->user()->id,
                'id_dest' => $id_dest->user_id,
                'data' => time(),
                'texto' => 'Iniciou uma discussão no grupo "'.Grupo::verGrupo($request->idgrupo)->nome.'"',
                'is_post' => false,
                'action' => '/grupo/'.Grupo::verGrupo($request->idgrupo)->url,
            ]);
        }

        return Response::json(['disc' => $disc]);
    }

    public function delDisc(Request $request)
    {
        //conferir o App Provider! Não está decrementando.
        if (GrupoDiscussao::where('id', $request->discussao_id)->select(['id'])->first()) {
            if (GrupoDiscussao::where('id', $request->discussao_id)->delete()) {
                return Response::json(['response' => 1, 'id' => $request->discussao_id]); //passa junto o id da discussao para dar o fadeOut na view.
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function newDisc(Request $request)
    {
        Carbon::setLocale('pt_BR');

        $discussoes = GrupoDiscussao::orderBy('created_at', 'desc')
                ->where('id', '>', $request->id)
                ->get();
        $grupo = Grupo::where('id', $discussoes->grupo_id)->get();

        return view('grupo.novaDiscussao', ['discussoes' => $discussoes, 'grupo' => $grupo]);
    }

    public function setPerg(Request $request)
    {
        $this->validate($request, ['pergunta' => 'required']);

        GrupoPergunta::create([
            'grupo_id' => $request->idgrupo,
            'assunto' => $request->assunto ? $request->assunto : null,
            'autor_id' => auth()->user()->id,
            'pergunta' => $request->pergunta,
        ]);

        $this->setAtiv($request->idgrupo, $request->pergunta, 'pergunta', Carbon::now(), auth()->user()->id);

        $id_dests = GrupoUser::where('grupo_id', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
        foreach ($id_dests as $id_dest) {
            Notificacao::create([
                'rem_id' => auth()->user()->id,
                'id_dest' => $id_dest->user_id,
                'data' => time(),
                'texto' => 'Perguntou no grupo "'.Grupo::verGrupo($request->idgrupo)->nome.'"',
                'is_post' => false,
                'action' => '/grupo/'.Grupo::verGrupo($request->idgrupo)->url,
            ]);
        }

        return Response::json(['request' => $perg]);
    }

    public function delPerg(Request $request)
    {
        if (GrupoPergunta::where('id', $request->id_pergunta)->first()) {
            if (GrupoPergunta::where('id', $request->id_pergunta)->delete()) {
                return Response::json(['response' => 1, 'id' => $request->id_pergunta]); //passa junto o id da pergunta para dar o fadeOut na view.
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function setMat(Request $request)
    {

        //if (($request->nomeCam) or ( $request->nomeMid) or ( $request->nomeDoc)) {

        if (($request->caminho) || ($request->documento) || ($request->midia)) {
            $mat = new GrupoMaterial();
            $mat->grupo_id = $request->grupo_id;
            $mat->autor_id = auth()->user()->id;
            if (Input::hasFile('midia')) {
                $ext = Input::file('midia')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionMidia)) {
                    Input::file('midia')->move($this->MidiaDestinationPath, md5(auth()->user()->id.Carbon::now()).'.'.$ext);
                    $mat->caminho = $this->MidiaDestinationPath.'/'.md5(auth()->user()->id.Carbon::now()).'.'.$ext;
                    $mat->nome = $request->nomeMid;
                    $mat->tipo = 'midia';
                } else {
                    return Response::json(['response' => 4]);
                }
            } elseif (Input::hasFile('documento')) {
                $ext = Input::file('documento')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionDocs)) {
                    Input::file('documento')->move($this->DocsDestinationPath, md5(auth()->user()->id.Carbon::now()).'.'.$ext);
                    $mat->caminho = $this->DocsDestinationPath.'/'.md5(auth()->user()->id.Carbon::now()).'.'.$ext;
                    $mat->nome = $request->nomeDoc;
                    $mat->tipo = 'documento';
                } else {
                    return Response::json(['response' => 4]);
                }
            } elseif ($request->caminho) {
                $mat->nome = $request->nomeEnd;
                $mat->caminho = $request->caminho;
                $mat->tipo = 'link';
            }
            if ($request->documento) {
                $mat->nome = $request->nomeDoc;
                //$mat->caminho = $request->documento;
                $mat->tipo = 'documento';
            }
            if ($mat->save() and ($this->setAtiv($mat->grupo_id, $mat->nome, $mat->tipo, Carbon::now(), auth()->user()->id))) {
                $id_dests = GrupoUser::where('grupo_id', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
                foreach ($id_dests as $id_dest) {
                    Notificacao::create([
                        'rem_id' => auth()->user()->id,
                        'id_dest' => $id_dest->user_id,
                        'data' => time(),
                        'texto' => 'Adicionou um material no grupo "'.Grupo::verGrupo($request->idgrupo)->nome.'"',
                        'is_post' => false,
                        'action' => '/grupo/'.Grupo::verGrupo($request->idgrupo)->url,
                    ]);
                }

                return Response::json(['response' => 1]);
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => 3]);
    }

    public function edit(Request $request)
    {
        if ($request->nome) {
            $update_nome = Grupo::where('id', $request->idgrupo)
                    ->update(array('nome' => $request->nome));
            $update = true;
        }
        if ($request->url) {
            if (!Grupo::where('url', $request->url)->where('id', '<>', $request->idgrupo)->first()) {
                Grupo::where('id', $request->idgrupo)->update(array('url' => $request->url));
                $update = true;
            } else {
                return Response::json(['status' => 3]);
            }
        }
        if ($request->expiracao) {
            Grupo::where('id', $request->idgrupo)->update(array('expiracao' => $request->expiracao));
            $update = true;
        }
        if ($request->assunto) {
            Grupo::where('id', $request->idgrupo)->update(array('assunto' => $request->assunto));
            $update = true;
        }
        if ($update != 0) {
            $id_dests = GrupoUser::where('grupo_id', $request->idgrupo)->select(['user_id'])->where('is_admin', 0);
            foreach ($id_dests as $id_dest) {
                Notificacao::create([
                    'rem_id' => auth()->user()->id,
                    'id_dest' => $id_dest->user_id,
                    'data' => time(),
                    'texto' => 'Editou algumas informações do grupo "'.Grupo::verGrupo($request->idgrupo)->nome.'"',
                    'is_post' => false,
                    'action' => '/grupo/'.Grupo::verGrupo($request->idgrupo)->url,
                ]);
            }

            return Response::json(['status' => 1]);
        }

        return Response::json(['status' => 0]);
    }

    public function getGroupData($grupo)
    {
        Carbon::setLocale('pt_BR');
        $info = Grupo::where('id', $grupo->id)->get();
        $integrantes = GrupoUser::where('id', $grupo->id)->where('is_banido', 0)->get();
        $discussoes = GrupoDiscussao::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $perguntas = GrupoPergunta::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $materiais = GrupoMaterial::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();

        $amigos = User::join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('users.id', '!=', auth()->user()->id)
                ->select(['users.id', 'users.name'])
                ->where('amizades.user_id2', auth()->user()->id)
                ->get();

        $amigos_nao_int = array();
        foreach ($amigos as $amigo) {
            if (!GrupoUser::where('user_id', $amigo->id)->where('grupo_id', $grupo->id)->first()) {
                $amigos_nao_int[] = $amigo;
            }
        }

        $alunos = User::where('type', 1)->get();
        $alunos_int = array();
        foreach ($alunos as $aluno) {
            if (GrupoUser::where('user_id', $aluno->id)->where('grupo_id', $grupo->id)->where('is_banido', 0)->first()) {
                $alunos_int[] = $aluno;
            }
        }

        $alunos_ban = array();
        foreach ($alunos as $aluno) {
            if (GrupoUser::where('user_id', $aluno->id)->where('grupo_id', $grupo->id)->where('is_banido', 1)->first()) {
                $alunos_ban[] = $aluno;
            }
        }

        $alunos_nao_int = array();
        foreach ($alunos as $aluno) {
            if (!GrupoUser::where('user_id', $aluno->id)->where('grupo_id', $grupo->id)->first()) {
                $alunos_nao_int[] = $aluno;
            }
        }

        $professores = User::where('type', 2)->get();
        $professores_int = array();
        foreach ($professores as $professor) {
            if (GrupoUser::where('user_id', $professor->id)->where('grupo_id', $grupo->id)->first()) {
                $professores_int[] = $professor;
            }
        }

        $professores_nao_int = array();
        foreach ($professores as $professor) {
            if (!GrupoUser::where('user_id', $professor->id)->where('grupo_id', $grupo->id)->first()) {
                $professores_nao_int[] = $professor;
            }
        }

        $integrante = GrupoUser::where('grupo_id', $grupo->id)
                ->where('user_id', auth()->user()->id)
                ->first();

        return [
            'atv' => $integrante->is_admin ? $this->getAtiv($grupo->id) : null,
            'grupo' => $grupo,
            'banido' => 0,
            'info' => $info,
            'alunos_int' => $alunos_int,
            'alunos_nao_int' => $alunos_nao_int,
            'integrantes' => $integrantes,
            'discussoes' => $discussoes,
            'materiais' => $materiais,
            'integranteEu' => $integrante,
            'amigos' => $amigos,
            'amigos_nao_int' => $amigos_nao_int,
            'professores_int' => $professores_int,
            'professores_nao_int' => $professores_nao_int,
            'perguntas' => $perguntas,
            'infoAcad' => User::getInfoAcademica(),
        ];
    }

    public function getGroupDataExp($grupo)
    {
        $info = Grupo::where('id', $grupo->id)->get();
        $integrantes = GrupoUser::where('id', $grupo->id)->where('is_banido', 0)->get();
        $discussoes = GrupoDiscussao::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $perguntas = GrupoPergunta::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $materiais = GrupoMaterial::where('grupo_id', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();

        $alunos = User::where('type', 1)->get();
        $alunos_int = array();
        foreach ($alunos as $aluno) {
            if (GrupoUser::where('user_id', $aluno->id)->where('grupo_id', $grupo->id)->where('is_banido', 0)->first()) {
                $alunos_int[] = $aluno;
            }
        }

        $professores = User::where('type', 2)->get();
        $professores_int = array();
        foreach ($professores as $professor) {
            if (GrupoUser::where('user_id', $professor->id)->where('grupo_id', $grupo->id)->first()) {
                $professores_int[] = $professor;
            }
        }

        $integrante = GrupoUser::where('grupo_id', $grupo->id)
                ->where('user_id', auth()->user()->id)
                ->first();

        return [
            'grupo' => $grupo,
            'banido' => 0,
            'expirado' => 1,
            'info' => $info,
            'alunos_int' => $alunos_int,
            'integrantes' => $integrantes,
            'discussoes' => $discussoes,
            'materiais' => $materiais,
            'integranteEu' => $integrante,
            'professores_int' => $professores_int,
            'perguntas' => $perguntas,
            'infoAcad' => User::getInfoAcademica(),
        ];
    }

    public function getGroupDataBan($grupo)
    {
        $discussoes = GrupoDiscussao::where('grupo_id', $grupo->id)
                ->where('autor_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

        $perguntas = GrupoPergunta::where('grupo_id', $grupo->id)
                ->where('autor_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

        $materiais = GrupoMaterial::where('grupo_id', $grupo->id)
                ->where('autor_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

        $amigos = User::join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('users.id', '!=', auth()->user()->id)
                ->select(['users.id', 'users.name'])
                ->where('amizades.user_id2', auth()->user()->id)
                ->get();

        $amigos_nao_int = array();
        foreach ($amigos as $amigo) {
            if (!GrupoUser::where('user_id', $amigo->id)->where('grupo_id', $grupo->id)->first()) {
                $amigos_nao_int[] = $amigo;
            }
        }
        $alunos = User::where('type', 1)->get();
        $alunos_nao_int = array();
        foreach ($alunos as $aluno) {
            if (!GrupoUser::where('user_id', $aluno->id)->where('grupo_id', $grupo->id)->first()) {
                $alunos_nao_int[] = $aluno;
            }
        }
        $professores = User::where('type', 2)->get();
        $professores_nao_int = array();
        foreach ($professores as $professor) {
            if (!GrupoUser::where('user_id', $professor->id)->where('grupo_id', $grupo->id)->first()) {
                $professores_nao_int[] = $professor;
            }
        }

        return [
            'banido' => 1,
            'professores_nao_int' => $professores_nao_int,
            'alunos_nao_int' => $alunos_nao_int,
            'mat' => $materiais,
            'discussoes' => $discussoes,
            'perguntas' => $perguntas,
            'grupo' => $grupo,
            'infoAcad' => User::getInfoAcademica(),
        ];
    }

    public function sair(Request $request)
    {
        if (GrupoUser::where('user_id', auth()->user()->id)
                        ->where('grupo_id', $request->grupo_id)
                        ->delete()) {
            $texto = 'O usuário '.User::verUser(auth()->user()->id)->nome.' deixou o grupo "'.Grupo::verGrupo($request->grupo_id)->nome.'", pois segundo ele, '.$request->motivo;
            if (DB::table('notificacaos')->insert([
                        'rem_id' => auth()->user()->id,
                        'id_dest' => GrupoUser::where('grupo_id', $request->grupo_id)->where('is_admin', 1)->get(),
                        'data' => Carbon::today()->timestamp,
                        'texto' => $texto,
                    ])) {
                return Response::json(['response' => 1]);
            }

            return Response::json(['response' => 2]);
        }

        return Response::json(['response' => false]);
    }

    public function excluir(Request $request)
    {
        if ((GrupoUser::where('grupo_id', $request->idgrupo)->delete()) and (Grupo::where('id', $request->idgrupo)->delete())) {
            return Response::json(['status' => true]);
        } else {
            return false;
        }
    }

    public function setAtiv($grupo_id, $desc, $tipo, $data_evento, $rem_id)
    {
        GrupoAtiv::create([
            'grupo_id' => $grupo_id,
            'tipo' => $tipo,
            'desc' => $desc ? $desc : null,
            'data_evento' => $data_evento ? $data_evento : null,
            'rem_id' => $rem_id ? $rem_id : null,
        ]);
    }

    public function getAtiv($grupo_id)
    {
        $atv[] = GrupoAtiv::where('grupo_id', $grupo_id)
                ->where('tipo', 'discussao')
                ->orderBy('created_at', 'desc')
                ->first();
        $atv[] = GrupoAtiv::where('grupo_id', $grupo_id)
                ->where('tipo', 'pergunta')
                ->orderBy('created_at', 'desc')
                ->first();
        $atv[] = GrupoAtiv::where('grupo_id', $grupo_id)
                ->where('tipo', 'material')
                ->orderBy('created_at', 'desc')
                ->first();

        return $atv;
    }
}
