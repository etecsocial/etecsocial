<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\GrupoAtiv;
use App\GrupoDiscussao;
use App\GrupoMaterial;
use App\GrupoPergunta;
use App\GrupoUsuario;
use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Notificacao;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;

class GrupoController extends Controller {

    /**
     * Classe controladora de grupos de estudo.
     *
     * @2015 ETEC Social.
     */
    public $extensionMidia = ['flv', 'FLV', 'mp4', 'MP4', 'jpg', 'JPG', 'png', 'PNG', 'gif'];
    public $extensionDocs = ['pdf', 'txt', 'doc', 'docx', 'pptx', 'xls'];
    public $MidiaDestinationPath = 'midia/grupos';
    public $DocsDestinationPath = 'docs/grupos';

    public function listar() {
        Carbon::setLocale('pt_BR');
        $grupos = GrupoUsuario::where('user_id', auth()->user()->id)
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.id_grupo')
                ->get();

        $amigos = User::join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('users.id', "!=", auth()->user()->id)
                ->select(['users.id', 'users.name'])
                ->where('amizades.user_id2', auth()->user()->id)
                ->get();

        $professores = User::where('type', 2)->get();

        return view('grupo.lista', ['infoAcad' => User::getInfoAcademica(), 'grupos' => $grupos, 'amigos' => $amigos, 'professores' => $professores, 'msgsUnread' => Mensagens::countUnread()])->with(['thisUser' => auth()->user()]);
    }

    public function index($groupname) {
        Carbon::setLocale('pt_BR');
        if ($grupo = Grupo::where('url', $groupname)->first()) {
//Verifica se o grupo existe
            if (($grupo->expiracao > \Carbon\Carbon::today()) or ( $grupo->expiracao == null)) {
                //Verifica se é expirado
                if (GrupoUsuario::where('user_id', auth()->user()->id)->where('id_grupo', $grupo->id)->where('is_banido', 0)->first()) { //Verifica se o usuário é integrante e não está banido
                    return view('grupo.home', $dados = $this->getGroupData($grupo))->with(['msgsUnread' => Mensagens::countUnread()]);
                } elseif (GrupoUsuario::where('user_id', auth()->user()->id)->where('id_grupo', $grupo->id)->where('is_banido', 1)->first()) { //Verifica se o usuário é banido, já que a seleção anterior falhou
                    return view('grupo.home', $this->getGroupDataBan($grupo))->with(['msgsUnread' => Mensagens::countUnread()]); //Retorna a view com os dados
                } else {
//O usuário não é integrante do grupo
                    return abort(405);
                }
            } else {
//O grupo expirou.
                if (GrupoUsuario::where('user_id', auth()->user()->id)->where('id_grupo', $grupo->id)->where('is_banido', 0)->first()) {
                    return view('grupo.home', $dados = $this->getGroupDataExp($grupo))->with(['msgsUnread' => Mensagens::countUnread()]);
                } elseif (GrupoUsuario::where('user_id', auth()->user()->id)->where('id_grupo', $grupo->id)->where('is_banido', 1)->first()) {

                    return view('grupo.home', $this->getGroupDataBan($grupo))->with(['msgsUnread' => Mensagens::countUnread()]);
                } else {
//USUÁRIO NAO ESTÁ NO GRUPO
                    return abort(405);
                }
            }
        } else {
//grupo nao existe
            return abort(404);
        }
    }

    /**
     * Cria grupo de estudos.
     * Requests - nome, url, assunto, expiracao.
     */
    public function criar(Request $request) {
        if (($request->nome) and ( $request->assunto)) {
            if ($request->url and ( Grupo::where('url', $request->url)->count())) {
                return Response::json(['status' => 3]);
            }
            if ($request->expiracao and $request->expiracao >= \Carbon\Carbon::today()) {
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
                        'expiracao' => isset($exp) ? $exp : null
            ]);
            return Response::json(['status' => 1, 'nome' => $g->nome, 'url' => $g->url]);
        }return Response::json(['status' => 4]);
    }

    /**
     * Adiciona aluno ao grupo, chamada quando utilizada uma modal.
     * Variáveis - id_grupo, alunos.
     */
    public function addAluno($id_grupo, $alunos) {
        foreach ($alunos as $aluno) {
            GrupoUsuario::create([
                'id_grupo' => $id_grupo,
                'user_id' => $aluno
            ]);
        }
    }

    /**
     * Adiciona aluno ao grupo, chamada por AJAX.
     * Requests - id_grupo, alunos.
     * Falta notificar admin que o aluno entrou
     * EDITADO
     */
    public function addAlunoDir(Request $request) {
        if (!GrupoUsuario::where('id_grupo', $request->id_grupo)->where('user_id', $request->id_amigo)->first()) {
            if (GrupoUsuario::create([
                        'id_grupo' => $request->id_grupo,
                        'user_id' => $request->id_amigo
                    ])) {
                Notificacao::create([
                    'id_rem' => auth()->user()->id,
                    'id_dest' => $request->id_amigo,
                    'data' => time(),
                    'texto' => "Adicionou você ao grupo '" . Grupo::verGrupo($request->id_grupo)->nome . "'",
                    'is_post' => false,
                    'action' => '/grupo/' . Grupo::verGrupo($request->id_grupo)->url,
                ]);
                return Response::json(['response' => 1]);
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

//    public function addProfDir(Request $request) { //CRIA A NOTIFICAÇÃO PARA O PROFESSOR
    //        $add = new GrupoUsuario;
    //        $add->id_grupo = $request->id_grupo;
    //        $add->user_id = $request->id_prof;
    //        if ($add->save()) {
    //            $this->IncParticipante($request->id_grupo);
    //            return Response::json([ 'response' => 1]);
    //        }return Response::json([ 'response' => 0]);
    //    }

    public function addProfGrupo(Request $request) {
        //SALVA NO DB APÓS CONFIRMAÇÃO (ou nao)
        if (!GrupoUsuario::where('user_id', $request->id_professor)->where('id_grupo', $request->id_grupo)->first()) {
            return GrupoUsuario::create([
                        'id_grupo' => $request->id_grupo,
                        'user_id' => $request->id_professor
                    ]) ? Response::json(['response' => 1]) : Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

    public function removeAlunoGrupo(Request $request) {
        // Remove o aluno do grupo
        if (GrupoUsuario::where('user_id', $request->id_aluno)->where('id_grupo', $request->id_grupo)->first()) {
            if (GrupoUsuario::where('user_id', $request->id_aluno)
                            ->where('id_grupo', $request->id_grupo)
                            ->update(array('is_banido' => 1))) {
                Notificacao::create([
                    'id_rem' => $request->id_aluno,
                    'id_dest' => $request->id_aluno,
                    'data' => time(),
                    'texto' => 'Você foi banido do grupo "' . Grupo::verGrupo($request->id_grupo)->nome . '" pelo administrador.',
                    'is_post' => false,
                    'action' => '/grupo/' . Grupo::verGrupo($request->id_grupo)->url,
                ]);
                return Response::json(['response' => 1]);
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

    public function setDisc(Request $request) {
        $this->validate($request, ['assunto' => 'required']);
        $this->validate($request, ['discussao' => 'required']);

        $disc = GrupoDiscussao::create([
                    'id_grupo' => $request->idgrupo,
                    'titulo' => $request->titulo ? $request->titulo : 'Sem título',
                    'id_autor' => auth()->user()->id,
                    'assunto' => $request->assunto,
                    'discussao' => $request->discussao
        ]);

        $this->setAtiv($request->idgrupo, null, 'discussao', \Carbon\Carbon::now(), auth()->user()->id);

        $id_dests = GrupoUsuario::where('id_grupo', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
        foreach ($id_dests as $id_dest) {
            Notificacao::create([
                'id_rem' => auth()->user()->id,
                'id_dest' => $id_dest->user_id,
                'data' => time(),
                'texto' => 'Iniciou uma discussão no grupo "' . Grupo::verGrupo($request->idgrupo)->nome . '"',
                'is_post' => false,
                'action' => '/grupo/' . Grupo::verGrupo($request->idgrupo)->url,
            ]);
        }
        return Response::json(['disc' => $disc]);
    }

    public function delDisc(Request $request) {
        //conferir o App Provider! Não está decrementando.
        if (GrupoDiscussao::where('id', $request->id_discussao)->select(['id'])->first()) {
            if (GrupoDiscussao::where('id', $request->id_discussao)->delete()) {
                return Response::json(['response' => 1, 'id' => $request->id_discussao]); //passa junto o id da discussao para dar o fadeOut na view.
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

    public function newDisc(Request $request) {
        Carbon::setLocale('pt_BR');

        $discussoes = GrupoDiscussao::orderBy('created_at', 'desc')
                ->where('id', '>', $request->id)
                ->get();
        $grupo = Grupo::where('id', $discussoes->id_grupo)->get();

        return view('grupo.novaDiscussao', ['discussoes' => $discussoes, 'grupo' => $grupo]);
    }

    public function setPerg(Request $request) {
        $this->validate($request, ['pergunta' => 'required']);

        GrupoPergunta::create([
            'id_grupo' => $request->idgrupo,
            'assunto' => $request->assunto ? $request->assunto : null,
            'id_autor' => auth()->user()->id,
            'pergunta' => $request->pergunta
        ]);

        $this->setAtiv($request->idgrupo, $request->pergunta, 'pergunta', \Carbon\Carbon::now(), auth()->user()->id);

        $id_dests = GrupoUsuario::where('id_grupo', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
        foreach ($id_dests as $id_dest) {
            Notificacao::create([
                'id_rem' => auth()->user()->id,
                'id_dest' => $id_dest->user_id,
                'data' => time(),
                'texto' => 'Perguntou no grupo "' . Grupo::verGrupo($request->idgrupo)->nome . '"',
                'is_post' => false,
                'action' => '/grupo/' . Grupo::verGrupo($request->idgrupo)->url,
            ]);
        }
        return Response::json(["request" => $perg]);
    }

    public function delPerg(Request $request) {
        if (GrupoPergunta::where('id', $request->id_pergunta)->first()) {
            if (GrupoPergunta::where('id', $request->id_pergunta)->delete()) {
                return Response::json(['response' => 1, 'id' => $request->id_pergunta]); //passa junto o id da pergunta para dar o fadeOut na view.
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

    public function setMat(Request $request) {

        //if (($request->nomeCam) or ( $request->nomeMid) or ( $request->nomeDoc)) {

        if (($request->caminho) || ($request->documento) || ($request->midia)) {

            $mat = new GrupoMaterial;
            $mat->id_grupo = $request->id_grupo;
            $mat->id_autor = auth()->user()->id;
            if (Input::hasFile('midia')) {
                $ext = Input::file('midia')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionMidia)) {
                    Input::file('midia')->move($this->MidiaDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $mat->caminho = $this->MidiaDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
                    $mat->nome = $request->nomeMid;
                    $mat->tipo = 'midia';
                } else {
                    return Response::json(['response' => 4]);
                }
            } elseif (Input::hasFile('documento')) {
                $ext = Input::file('documento')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionDocs)) {
                    Input::file('documento')->move($this->DocsDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $mat->caminho = $this->DocsDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
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
            if ($mat->save() and ( $this->setAtiv($mat->id_grupo, $mat->nome, $mat->tipo, \Carbon\Carbon::now(), auth()->user()->id))) {
                $id_dests = GrupoUsuario::where('id_grupo', $request->idgrupo)->select(['user_id'])->where('user_id', '<>', auth()->user()->id)->get();
                foreach ($id_dests as $id_dest) {
                    Notificacao::create([
                        'id_rem' => auth()->user()->id,
                        'id_dest' => $id_dest->user_id,
                        'data' => time(),
                        'texto' => 'Adicionou um material no grupo "' . Grupo::verGrupo($request->idgrupo)->nome . '"',
                        'is_post' => false,
                        'action' => '/grupo/' . Grupo::verGrupo($request->idgrupo)->url,
                    ]);
                }
                return Response::json(['response' => 1]);
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => 3]);
    }

    public function edit(Request $request) {
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
            $id_dests = GrupoUsuario::where('id_grupo', $request->idgrupo)->select(['user_id'])->where('is_admin', 0);
            foreach ($id_dests as $id_dest) {
                Notificacao::create([
                    'id_rem' => auth()->user()->id,
                    'id_dest' => $id_dest->user_id,
                    'data' => time(),
                    'texto' => 'Editou algumas informações do grupo "' . Grupo::verGrupo($request->idgrupo)->nome . '"',
                    'is_post' => false,
                    'action' => '/grupo/' . Grupo::verGrupo($request->idgrupo)->url,
                ]);
            }return Response::json(['status' => 1]);
        }return Response::json(['status' => 0]);
    }

    public function getGroupData($grupo) {
        Carbon::setLocale('pt_BR');
        $info = Grupo::where('id', $grupo->id)->get();
        $integrantes = GrupoUsuario::where('id', $grupo->id)->where('is_banido', 0)->get();
        $discussoes = GrupoDiscussao::where('id_grupo', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $perguntas = GrupoPergunta::where('id_grupo', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $materiais = GrupoMaterial::where('id_grupo', $grupo->id)
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
            if (!GrupoUsuario::where('user_id', $amigo->id)->where('id_grupo', $grupo->id)->first()) {
                $amigos_nao_int[] = $amigo;
            }
        }

        $alunos = User::where('type', 1)->get();
        $alunos_int = array();
        foreach ($alunos as $aluno) {
            if (GrupoUsuario::where('user_id', $aluno->id)->where('id_grupo', $grupo->id)->where('is_banido', 0)->first()) {
                $alunos_int[] = $aluno;
            }
        }

        $alunos_ban = array();
        foreach ($alunos as $aluno) {
            if (GrupoUsuario::where('user_id', $aluno->id)->where('id_grupo', $grupo->id)->where('is_banido', 1)->first()) {
                $alunos_ban[] = $aluno;
            }
        }

        $alunos_nao_int = array();
        foreach ($alunos as $aluno) {
            if (!GrupoUsuario::where('user_id', $aluno->id)->where('id_grupo', $grupo->id)->first()) {
                $alunos_nao_int[] = $aluno;
            }
        }

        $professores = User::where('type', 2)->get();
        $professores_int = array();
        foreach ($professores as $professor) {
            if (GrupoUsuario::where('user_id', $professor->id)->where('id_grupo', $grupo->id)->first()) {
                $professores_int[] = $professor;
            }
        }

        $professores_nao_int = array();
        foreach ($professores as $professor) {
            if (!GrupoUsuario::where('user_id', $professor->id)->where('id_grupo', $grupo->id)->first()) {
                $professores_nao_int[] = $professor;
            }
        }

        $integrante = GrupoUsuario::where('id_grupo', $grupo->id)
                ->where('user_id', auth()->user()->id)
                ->first();

        return ([
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
            'infoAcad' => User::getInfoAcademica()
        ]);
    }

    public function getGroupDataExp($grupo) {
        $info = Grupo::where('id', $grupo->id)->get();
        $integrantes = GrupoUsuario::where('id', $grupo->id)->where('is_banido', 0)->get();
        $discussoes = GrupoDiscussao::where('id_grupo', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $perguntas = GrupoPergunta::where('id_grupo', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();
        $materiais = GrupoMaterial::where('id_grupo', $grupo->id)
                ->orderBy('created_at', 'desc')
                ->get();

        $alunos = User::where('type', 1)->get();
        $alunos_int = array();
        foreach ($alunos as $aluno) {
            if (GrupoUsuario::where('user_id', $aluno->id)->where('id_grupo', $grupo->id)->where('is_banido', 0)->first()) {
                $alunos_int[] = $aluno;
            }
        }

        $professores = User::where('type', 2)->get();
        $professores_int = array();
        foreach ($professores as $professor) {
            if (GrupoUsuario::where('user_id', $professor->id)->where('id_grupo', $grupo->id)->first()) {
                $professores_int[] = $professor;
            }
        }

        $integrante = GrupoUsuario::where('id_grupo', $grupo->id)
                ->where('user_id', auth()->user()->id)
                ->first();

        return ([
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
            'infoAcad' => User::getInfoAcademica()
        ]);
    }

    public function getGroupDataBan($grupo) {
        $discussoes = GrupoDiscussao::where('id_grupo', $grupo->id)
                ->where('id_autor', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

        $perguntas = GrupoPergunta::where('id_grupo', $grupo->id)
                ->where('id_autor', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

        $materiais = GrupoMaterial::where('id_grupo', $grupo->id)
                ->where('id_autor', auth()->user()->id)
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
            if (!GrupoUsuario::where('user_id', $amigo->id)->where('id_grupo', $grupo->id)->first()) {
                $amigos_nao_int[] = $amigo;
            }
        }
        $alunos = User::where('type', 1)->get();
        $alunos_nao_int = array();
        foreach ($alunos as $aluno) {
            if (!GrupoUsuario::where('user_id', $aluno->id)->where('id_grupo', $grupo->id)->first()) {
                $alunos_nao_int[] = $aluno;
            }
        }
        $professores = User::where('type', 2)->get();
        $professores_nao_int = array();
        foreach ($professores as $professor) {
            if (!GrupoUsuario::where('user_id', $professor->id)->where('id_grupo', $grupo->id)->first()) {
                $professores_nao_int[] = $professor;
            }
        }

        return ([
            'banido' => 1,
            'professores_nao_int' => $professores_nao_int,
            'alunos_nao_int' => $alunos_nao_int,
            'mat' => $materiais,
            'discussoes' => $discussoes,
            'perguntas' => $perguntas,
            'grupo' => $grupo,
            'infoAcad' => User::getInfoAcademica()
        ]);
    }

    public function sair(Request $request) {
        if (GrupoUsuario::where('user_id', auth()->user()->id)
                        ->where('id_grupo', $request->id_grupo)
                        ->delete()) {
            $texto = 'O usuário ' . User::verUser(auth()->user()->id)->nome . ' deixou o grupo "' . Grupo::verGrupo($request->id_grupo)->nome . '", pois segundo ele, ' . $request->motivo;
            if (DB::table('notificacaos')->insert([
                        'id_rem' => auth()->user()->id,
                        'id_dest' => GrupoUsuario::where('id_grupo', $request->id_grupo)->where('is_admin', 1)->get(),
                        'data' => Carbon::today()->timestamp,
                        'texto' => $texto,
                    ])) {
                return Response::json(['response' => 1]);
            }return Response::json(['response' => 2]);
        }return Response::json(['response' => false]);
    }

    public function excluir(Request $request) {
        if ((GrupoUsuario::where('id_grupo', $request->idgrupo)->delete()) and ( Grupo::where('id', $request->idgrupo)->delete())) {
            return Response::json(['status' => true]);
        } else {
            return false;
        }
    }

    public function setAtiv($id_grupo, $desc, $tipo, $data_evento, $id_rem) {
        GrupoAtiv::create([
            'id_grupo' => $id_grupo,
            'tipo' => $tipo,
            'desc' => $desc ? $desc : null,
            'data_evento' => $data_evento ? $data_evento : null,
            'd_rem' => $id_rem ? $id_rem : null
        ]);
    }

    public function getAtiv($id_grupo) {
        $atv[] = GrupoAtiv::where('id_grupo', $id_grupo)
                ->where('tipo', 'discussao')
                ->orderBy('created_at', 'desc')
                ->first();
        $atv[] = GrupoAtiv::where('id_grupo', $id_grupo)
                ->where('tipo', 'pergunta')
                ->orderBy('created_at', 'desc')
                ->first();
        $atv[] = GrupoAtiv::where('id_grupo', $id_grupo)
                ->where('tipo', 'material')
                ->orderBy('created_at', 'desc')
                ->first();
        return $atv;
    }

}
