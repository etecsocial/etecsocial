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

    function getRandomNumbers($num, $min, $max, $repeat = false, $sort = false) {
        if ((($max - $min) + 1) >= $num) {
            $numbers = array();

            while (count($numbers) < $num) {
                $number = mt_rand($min, $max);

                if ($repeat || !in_array($number, $numbers)) {
                    $numbers[] = $number;
                }
            }

            switch ($sort) {
                case SORT_ASC:
                    sort($numbers);
                    break;
                case SORT_DESC:
                    rsort($numbers);
                    break;
            }

            return $numbers;
        }

        return false;
    }

    public function getAllEscolas() {
        return Escola::select('escolas.id', 'escolas.nome')->get();
    }

    public function getEscolasCad() {
        return Escola::select('escolas.id', 'escolas.nome')
                        ->whereIn('id', function ($query) {
                            $query->select('id_escola')
                            ->from('turmas');
                        })
                        ->get();
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

        if (auth()->user()->first_login == 3) {
            $escola = ProfessoresInfo::where('user_id', auth()->user()->id)->select(['id_escola as id', 'escolas.nome as etec'])
                            ->join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                            ->get()[0];
        } elseif (auth()->user()->first_login == 2) {
            $escola = ProfessoresInfo::join('escolas', 'escolas.id', '=', 'professores_info.id_escola')
                            ->select(['escolas.nome as etec', 'escolas.id as id'])
                            ->get()[0];
        } else {
            $escola = AlunosTurma::where('user_id', auth()->user()->id)
            ->join('turmas', 'turmas.id', '=', 'alunos_turma.id_turma')
            ->join('escolas', 'turmas.id_escola', '=', 'escolas.id')
            ->select(['turmas.nome as turma', 'turmas.sigla as sigla', 'escolas.nome as etec', 'alunos_turma.modulo as modulo', 'escolas.nome as etec'])
            ->get()[0];
        }


        return view('feed.home', ['posts' => $posts, 'tasks' => $tasks, 'id' => $id, 'grupos' => $grupos, 'thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread(), 'countPosts' => Post::count(), 'escola' => $escola]);
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
