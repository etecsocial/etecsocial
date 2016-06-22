<?php

namespace App\Http\Controllers;

use App\Escola;
use App\GrupoUsuario;
use App\AlunosTurma;
use App\ProfessoresInfo;
use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Post;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function index() {

        return auth()->check() ? $this->feed() : view('home.home', ['escolas' => $this->getAllEscolas(), 'escolasCad' => $this->getEscolasCad()]);
    }

    public function getAllEscolas() {
        return Escola::select('escolas.id', 'escolas.nome')->get();
    }

    public function getEscolasCad() {
        return Escola::select('escolas.id as id', 'escolas.nome as nome')
                        ->whereIn('id', function ($query) {
                            $query->select('id_escola')
                            ->from('turmas');
                        })
                        ->get()->toArray();
    }

    public function feed($id = 0) {

        $posts = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->limit(9)
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name'])
                ->get();


        $grupos = GrupoUsuario::where('id_user', auth()->user()->id)
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.id_grupo')
                ->where('grupo_usuario.is_banido', 0)
//->join('grupo_discussao', 'grupo_discussao.id_grupo', '=', 'grupo.id')
//->join('grupo_pergunta', 'grupo_pergunta.id_grupo', '=', 'grupo.id')
//->join('grupo_material', 'grupo_material.id_grupo', '=', 'grupo.id')
//->select('grupo.url', 'grupo.nome')
                ->limit(5)
                ->get();

        Carbon::setLocale('pt_BR');

        $tasks = DB::table('tarefas')
                ->select(['desc', 'data', 'checked', 'id'])
                ->where('id_user', auth()->user()->id)
                ->where(function ($query) {
                    $query->where('data_checked', '>', time() - 3 * 24 * 60 * 60)
                    ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(4)
                ->get();



        return view('feed.home', [
            'posts' => $posts,
            'tasks' => $tasks,
            'id' => $id,
            'grupos' => $grupos,
            'msgsUnread' => Mensagens::countUnread(),
            'countPosts' => Post::count(),
            'infoAcad' => $this->getInfoAcademica()
        ]);
    }

    function getInfoAcademica() {
        //VOU OTIMIZAR ISSO AINDA.
        switch (auth()->user()->type) {
            case 1:
                //Aluno
                if (auth()->user()->first_login == 0) {
                    return AlunosTurma::where('user_id', auth()->user()->id)
                                    ->join('turmas', 'turmas.id', '=', 'alunos_turma.id_turma')
                                    ->join('escolas', 'turmas.id_escola', '=', 'escolas.id')
                                    ->select(['turmas.nome as turma', 'turmas.sigla as sigla', 'escolas.nome as etec', 'alunos_turma.modulo as modulo', 'escolas.nome as etec'])
                                    ->get()[0];
                }
                //facebook login aqui, o first_login vai ser diferente...
                break;
            case 2:
                //PROFESSOR
                if (auth()->user()->first_login == 2) {
                    //DEVE SELECIONAR TURMAS QUE LECIONA
                    $info = ProfessoresInfo::
                                    where('user_id', auth()->user()->id)
                                    ->select(['id_escola as id', 'escolas.nome as escola'])
                                    ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                                    ->get()[0];
                } elseif (auth()->user()->first_login == 0) {
                    //TUDO OK, ABRIR FEED NORMALMENTE
                    $info = ProfessoresInfo::
                                    where('user_id', auth()->user()->id)
                                    ->select(['id_escola as id', 'escolas.nome as escola'])
                                    ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                                    ->get()[0];
                }
                break;
            case 3:
                //COORDENADOR
                if (auth()->user()->first_login == 3) {
                    //DEVE CADASTRAR TURMAS DA ESCOLA
                    $info = ProfessoresInfo::
                                    where('user_id', auth()->user()->id)
                                    ->select(['id_escola as id', 'escolas.nome as escola'])
                                    ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                                    ->get()[0];
                } elseif (auth()->user()->first_login == 2) {
                    //JÁ CADASTROU AS TURMAS, PRECISA DIZER PARA QUAIS ELE DÁ AULA (SE TAMBEM FOR PROF)
                    $info = ProfessoresInfo::
                                    where('user_id', auth()->user()->id)
                                    ->select(['id_escola as id', 'escolas.nome as escola'])
                                    ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                                    ->get()[0];
                } elseif (auth()->user()->first_login == 0) {
                    //JÁ CADASTROU E SELECIONOU AS SUAS. FEED NORMAL.
                    $info = ProfessoresInfo::
                                    where('user_id', auth()->user()->id)
                                    ->select(['id_escola as id', 'escolas.nome as escola'])
                                    ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                                    ->get()[0];
                }
                break;
            default:
                break;
        }return $info;
    }

    public function firstLogin() {
        switch (auth()->user()->first_login) {
            case 1:
                return $this->getInfoAcademica();
            case 2:
                $escola = ProfessoresInfo::join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                        ->select(['escolas.nome as escola', 'escolas.id as id'])
                        ->get();
                break;
            case 3:

                break;

            default:
                break;
        }
    }

    public function newpost(Request $request) {

        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->where('posts.id', '>', $request->id)
                ->get();

        return view('feed.posts', ['posts' => $posts, 'thisUser' => auth()->user()]);
    }

    public function morepost(Request $request) {
        $n = 9 - $request->tamanho % 9;

        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->limit($n)
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->where('posts.id', '<', $request->id)
                ->get();

        return view('feed.posts', ['posts' => $posts, 'thisUser' => auth()->user()]);
    }

}
