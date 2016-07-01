<?php

namespace App\Http\Controllers;

use App\Escola;
use App\GrupoUsuario;
use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function index() {
        return auth()->check() ? $this->feed() : view('home.home', [
                    'escolas' => $this->getAllEscolas(),
                    'escolasCad' => $this->getEscolasCad()
        ]);
    }

    public function getAllEscolas() {
        return Escola::all('escolas.id', 'escolas.nome');
    }

    public function getEscolasCad() {
        return Escola::select(['escolas.nome', 'escolas.id'])
                        ->join('turmas', 'turmas.escola_id', '=', 'escolas.id')->get();
    }

    public function feed($id = 0) {

        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
                ->join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.user_id2', auth()->user()->id)
                ->limit(9)
                ->latest()
                ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name'])
                ->get();
       


        $grupos = GrupoUsuario::where('user_id', auth()->user()->id)
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.grupo_id')
                ->where('grupo_usuario.is_banido', 0)
                ->select('grupo.url', 'grupo.nome')
                ->limit(5)
                ->get();

        Carbon::setLocale('pt_BR');
        $tasks = DB::table('tarefas')
                ->select(['desc', 'data', 'checked', 'id'])
                ->where('user_id', auth()->user()->id)
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
            'countPosts' => Post::count(),
        ]);
    }

    public function newpost(Request $request) {

        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.user_id2', auth()->user()->id)
                ->where('posts.id', '>', $request->id)
                ->get();

        return view('feed.posts', compact('posts'));
    }

    public function morepost(Request $request) {
        $n = 9 - $request->tamanho % 9;

        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->limit($n)
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.user_id2', auth()->user()->id)
                ->where('posts.id', '<', $request->id)
                ->get();

        return view('feed.posts', compact('posts'));
    }

}
