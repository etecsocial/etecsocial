<?php

namespace App\Http\Controllers;

use App\GrupoUser;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PesquisaController extends Controller
{
    public function index($termo = '')
    {
        $alunos = User::where('users.name', 'LIKE', '%' . $termo . '%')
            ->where('type', 1)
            ->where('users.id', '=!', auth()->user()->id) //para não exibir ele mesmo.
            ->limit(10)
            ->join('alunos_turma', 'alunos_turma.user_id', '=', 'users.id')
            ->join('turmas', 'turmas.id', '=', 'alunos_turma.turma_id')
            ->join('escolas', 'escolas.id', '=', 'turmas.escola_id')
            ->select(['users.id', 'users.name AS nome_usuario', 'users.username', 'alunos_turma.modulo', 'users.type', 'escolas.nome as nome_etec', 'turmas.sigla'])
            ->get();

        $professores = User::has('ProfInfo')
            ->where('name', 'LIKE', '%' . $termo . '%')
            //->join('professores_info', 'professores_info.user_id', '=', 'users.id')
            ->limit(10)
            //->select(['users.name', 'users.id as id', 'users.username as username', 'escolas.nome as escola'])

            ->get();

        $posts_amigos = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->join('amizades', 'amizades.user_id1', '=', 'users.id')
            ->orderBy('created_at', 'desc')
            ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
            ->where('amizades.aceitou', 1)
            ->where('amizades.user_id2', auth()->user()->id)
            ->where('titulo', 'LIKE', '%' . $termo . '%')
            ->orWhere('publicacao', 'LIKE', '%' . $termo . '%')
            ->limit(10)
            ->get();
//@todo tem que juntar essas duas queries acho
        $posts_publico = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->orderBy('created_at', 'desc')
            ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
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
        ]);
    }

    public function buscaRapida(Request $request)
    {
        if ($request->termo) {
            $usuarios = User::where('users.name', 'LIKE', '%' . $request->termo . '%')
                ->where('users.id', '=!', auth()->user()->id) //para não exibir ele mesmo.
                ->join('alunos_turma', 'alunos_turma.user_id', '=', 'users.id')
                ->join('turmas', 'turmas.id', '=', 'alunos_turma.turma_id')
                ->join('escolas', 'escolas.id', '=', 'turmas.escola_id')
                ->select(['users.id', 'users.name AS nome_usuario', 'users.username', 'alunos_turma.modulo', 'users.type', 'escolas.nome as nome_etec', 'turmas.sigla'])

                ->limit(4)
                ->get();

            return view('pesquisa.search', [
                'usuarios' => $usuarios,
                'grupos' => $this->getGrupos($request->termo, 3),
                'termo' => $request->termo,
            ]);
        }

        return;
    }

    public function getGrupos($termo, $limit)
    {
        return GrupoUser::where('user_id', auth()->user()->id) //Corrigido!
            ->join('grupo', 'grupo.id', '=', 'grupo_user.grupo_id')
            ->where('assunto', 'LIKE', '%' . $termo . '%')
            ->orWhere('materia', 'LIKE', '%' . $termo . '%')
            ->select(['grupo.id', 'nome', 'assunto', 'url', 'materia', 'num_participantes'])
            ->limit($limit)
            ->get();
    }
}
