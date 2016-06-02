<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\GrupoUsuario;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Mensagens;
use Illuminate\Http\Request;

class PesquisaController extends Controller {

    public function index($termo = '') {
        $alunos = User::where('users.name', 'LIKE', '%' . $termo . '%')
                ->where('type', 1)
                ->limit(10)
                ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                ->join('turmas', 'turmas.id', '=', 'alunos_info.id_turma')
                ->join('escolas', 'escolas.id', '=', 'turmas.id_escola')
                ->select(['users.id', 'users.name AS nome_usuario', 'users.username', 'users.type', 'escolas.nome as nome_etec', 'turmas.sigla'])
                ->get();

        $professores = User::where('name', 'LIKE', '%' . $termo . '%')
                ->where('type', 2)
                ->limit(10)
                ->get();

        $posts_amigos = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->where('titulo', 'LIKE', '%' . $termo . '%')
                ->orWhere('publicacao', 'LIKE', '%' . $termo . '%')
                ->limit(10)
                ->get();

        $posts_publico = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('is_publico', 1)
                ->where('titulo', 'LIKE', '%' . $termo . '%')
                ->orWhere('publicacao', 'LIKE', '%' . $termo . '%')
                ->limit(10)
                ->get();
        $grupos = $this->getGrupos($termo, 10);

        $count = ($alunos->count() + $professores->count() + $posts_amigos->count() +
                $posts_publico->count() + $grupos->count());
        return view('pesquisa.pesquisa', [
            'qtd_results' => $count,
            'termo' => $termo,
            'alunos' => $alunos,
            'professores' => $professores,
            'posts_amigos' => $posts_amigos,
            'posts_publicos' => $posts_publico,
            'grupos' => $grupos,
            'msgsUnread' => Mensagens::countUnread(),
        ]);
    }

    public function buscaRapida(Request $request) {
        if ($request->termo) {
            $usuarios = User::where('users.name', 'LIKE', '%' . $request->termo . '%')
                    ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                    ->join('turmas', 'turmas.id', '=', 'alunos_info.id_turma')
                    ->join('escolas', 'escolas.id', '=', 'turmas.id_escola')
                    ->select(['users.id', 'users.name AS nome_usuario', 'users.username', 'users.type', 'escolas.nome as nome_etec', 'turmas.sigla'])
                    ->limit(4)
                    ->get();
            return view('pesquisa.search', ['usuarios' => $usuarios, 'grupos' => $this->getGrupos($request->termo, 3), 'termo' => $request->termo]);
        }
        return;
    }

    public function getGrupos($termo, $limit) {
        return GrupoUsuario::where('id_user', auth()->user()->id) //Corrigido!
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.id_grupo')
                ->where('assunto', 'LIKE', '%' . $termo . '%')
                ->orWhere('materia', 'LIKE', '%' . $termo . '%')
                ->select(['grupo.id', 'nome', 'assunto', 'url', 'materia', 'num_participantes'])
                ->limit($limit)
                ->get();
    }

}
