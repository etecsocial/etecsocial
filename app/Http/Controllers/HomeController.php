<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use DB;
use App\Mensagens;
use App\GrupoUsuario;
use Carbon\Carbon;
use App\Escola;

class HomeController extends Controller {

    public function index() {
        $escolas = Escola::select('id', 'nome')->get();
        return auth()->check() ? $this->feed() : view('home.home', ['escolas' => $escolas]);
    }

    public function feed($id = 0) {
        $posts = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->limit(9)
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name'])
                ->get();

        $grupos = GrupoUsuario::where('id_user', auth()->user()->id)
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.id_grupo')
                ->limit(5)
                ->get();


        Carbon::setLocale('pt_BR');

        $tasks = DB::table('tarefas')
                ->select(['desc', 'data', 'checked', 'id'])
                ->where('id_user', auth()->user()->id)
                ->where(function($query) {
                    $query->where('data_checked', '>', time() - 3 * 24 * 60 * 60)
                    ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(4)
                ->get();
        return view('feed.home', ['posts' => $posts, 'tasks' => $tasks, 'id' => $id, 'grupos' => $grupos, 'thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread(), 'countPosts' => Post::count()]);
    }

    public function newpost(Request $request) {

        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
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
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id)
                ->where('posts.id', '<', $request->id)
                ->get();

        return view('feed.posts', [ 'posts' => $posts, 'thisUser' => auth()->user()]);
    }

}
