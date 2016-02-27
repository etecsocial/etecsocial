<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Auth;
use App\Post;
use App\Tag;
use App\Grupo;
use App\GrupoDiscussao;
use App\GrupoPergunta;
use App\User;

class TagController extends Controller {

    public function index($tag) {
        $this->show($tag);
    }

    /**
     * Middleware @Auth.
     *
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function show($tag) {

         $posts_amigos = Post::join('users', 'users.id', '=', 'posts.id_user')
                        ->join('tags', 'tags.id_post', '=', 'posts.id')
                        ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                        ->orderBy('created_at', 'desc')
                        ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                        ->where('tags.tag', $tag)
                        ->where('amizades.aceitou', 1)
                        ->where('amizades.id_user2', Auth::user()->id)
                        ->get();
        
       $posts_publicos =  Post::join('users', 'users.id', '=', 'posts.id_user')
                        ->join('tags', 'tags.id_post', '=', 'posts.id')
                        ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                        ->orderBy('created_at', 'desc')
                        ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                        ->where('tags.tag', $tag)
                        ->where('amizades.aceitou', 1)
                        ->where('amizades.id_user2', '<>', Auth::user()->id)
                        ->where('posts.is_publico',1)
                        ->get();

        return view('tags.posts', [ 'posts_amigos' => $posts_amigos, 'posts_publicos' => $posts_publicos]);
    }

}
