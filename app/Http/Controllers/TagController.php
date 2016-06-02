<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use App\Mensagens;

class TagController extends Controller
{

    public function index($tag)
    {
        $this->show($tag);
    }

    public function show($tag)
    {
        $posts = Post::join('users', 'users.id', '=', 'posts.id_user')
            ->join('tags', 'tags.id_post', '=', 'posts.id')
            ->join('amizades', 'amizades.id_user1', '=', 'users.id')
            ->orderBy('created_at', 'desc')
            ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
            ->where('tags.tag', $tag)
            ->where('amizades.aceitou', 1)
            ->where('amizades.id_user2', auth()->user()->id)
            ->orWhere('posts.is_publico', 1)
            ->distinct()
            ->get();        
        return view('tags.home', ['posts' => $posts, 'tag'=> $tag, 'msgsUnread' => Mensagens::countUnread()]);
    }

}
