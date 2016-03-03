<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use Auth;
use DB;

class PesquisaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Função que controla os três tipos de resultados que serão obtidos.
     *
     * 
     */
    public function index($termo) {

        $alunos = User::where("users.nome", 'LIKE', '%' . $termo . '%')
                ->where('tipo', 1)
                ->limit(10)
                ->join('turmas', 'turmas.id', '=', 'users.id_turma')
                ->join('lista_etecs', 'lista_etecs.id_etec', '=', 'turmas.id_escola')
                ->select([ 'users.id', 'users.nome AS nome_usuario', 'users.username', 'users.tipo', 'lista_etecs.nome as nome_etec', 'turmas.sigla', 'users.info_academica'])
                ->get();


        $professores = User::where('nome', 'LIKE', '%' . $termo . '%')
                ->where('tipo', 2)
                ->limit(10)
                ->get();

        $pub_amigos = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', Auth::user()->id)
                ->where('titulo', 'LIKE', '%' . $termo . '%')
                ->orWhere('publicacao', 'LIKE', '%' . $termo . '%')
                ->limit(10)
                ->get();
        $pub_outras = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', '<>', Auth::user()->id)
                ->where('titulo', 'LIKE', '%' . $termo . '%')
                ->limit(10)
                ->get();
        $qtd = ($alunos->count() + $professores->count());
        return view('pesquisa.result-pesquisa', [
            'qtd_results' => $qtd,
            'termo' => $termo,
            'alunos' => $alunos,
            'professores' => $professores,
            'pub_amigos' => $pub_amigos,
            'pub_outras' => $pub_outras,
        ]);
    }

    public function buscaRapida(Request $request) {
        if ($request->termo) {
            $alunos = User::where('users.nome', 'LIKE', '%' . $request->termo . '%')
                    ->join('turmas', 'turmas.id', '=', 'users.id_turma')
                    ->join('lista_etecs', 'lista_etecs.id_etec', '=', 'turmas.id_escola')
                    ->select([ 'users.id', 'users.nome AS nome_usuario', 'users.username', 'users.tipo', 'lista_etecs.nome as nome_etec', 'turmas.sigla', 'users.info_academica'])
                    ->limit(4)
                    ->get();
            $professores = User::where("users.nome", 'LIKE', '%' . $request->termo . '%')
                    ->where('tipo', 2)
                    ->limit(3)
                    ->get();
            return view('pesquisa.search', [ 'resultados_alunos' => $alunos, 'resultados_prof' => $professores, 'termo' => $request->termo]);
        }
        return;
    }
}