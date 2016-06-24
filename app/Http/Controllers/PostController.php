<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Pontuacao;
use App\Post;
use App\Tag;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;

class PostController extends Controller
{

    public $extensionImages = ['jpg', 'JPG', 'png', 'PNG'];
    public $extensionVideos = ['flv', 'FLV', 'mp4', 'MP4'];
    public $destinationPath = 'midia/posts';

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['publicacao' => 'required']);

        $post          = new Post;
        $post->user_id = auth()->user()->id;
        if ($request->titulo) {
            $post->titulo = $request->titulo;
        }
        $post->publicacao = $request->publicacao;
        $post->is_publico = $request->has('publico');
        $post->save();

        if ($request->has('tags')) {
            $tags = $this->addTags($request->tags, $post->id);
        } else {
            $tags = array('post');
        }

        if ($request->hasFile('midia')) {
            $this->addFile($request->midia, $post);
        } else {
            $this->addIcon($tags, $post);
        }
        
        Pontuacao::pontuar(10, 'novo post');
        
        return Response::json(["id" => $post->id, 'num_posts' => Post::count(), 'pontuacao' => Pontuacao::total()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->join('amizades', 'amizades.user_id1', '=', 'users.id')
            ->orderBy('created_at', 'desc')
            ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
            ->where('amizades.aceitou', 1)
            ->where('amizades.user_id2', auth()->user()->id)
            ->where('posts.id', $id)
            ->first();

        return isset($post) ? view('post.home', [
            'post'       => $post,
            'tags'       => Tag::where('post_id', $post->id)->get(),
            'thisUser'   => auth()->user(),
            'msgsUnread' => Mensagens::countUnread()])
        : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $post = Post::where('id', $id)->first();
        if (isset($request->titulo)) {
            $post->titulo = $request->titulo;
        } else {
            $post->titulo = 'Sem título';
        }

        $post->publicacao = $request->publicacao;
        $post->is_publico = $request->has('publico');
        $post->save();

        return $this->show($post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();

        if ($post->user_id !== auth()->user()->id) {
            return Response::json(['status' => false]);
        }
        $post->delete();

        return Response::json(['status' => true, 'id' => $id]);
    }

    public function favoritar(Request $request)
    {
        $post = Post::where('id', $request->post_id)->first();

        try {
            DB::table('favoritos')
                ->insert(['post_id' => $request->post_id, 'user_id' => auth()->user()->id]);

            $post->num_favoritos += 1;
            $post->save();

            return Response::json(['status' => true, 'num' => $post->num_favoritos - 1]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                DB::table('favoritos')
                    ->where(['post_id' => $request->post_id, 'user_id' => auth()->user()->id])
                    ->delete();

                $post->num_favoritos -= 1;
                $post->save();

                return Response::json(['status' => false, 'num' => $post->num_favoritos]);
            }
        }
    }

    public function addFile($midia, $post)
    {
        $ext = $midia->getClientOriginalExtension();

        if (in_array($ext, $this->extensionImages)) {
            $post->is_imagem = true;
        } else
        if (in_array($ext, $this->extensionVideos)) {
            $post->is_video = true;
        } else {
            return 'Erro ao adicionar mídia';
        }

        Input::file('midia')->move($this->destinationPath, md5($post->id));

        $post->url_midia = $this->destinationPath . '/' . md5($post->id);
        $post->save();
    }

    public function addTags($tags, $post_id)
    {
        $array = str_replace('#', '', explode(' ', $tags));

        $n = (count($array) > 3) ? 3 : count($array);

        for ($i = 0; $i < $n; $i++) {
            $array != '# ' ? Tag::create(['post_id' => $post_id, 'tag' => $array[$i]]) : false;
        }
        return $array; //não deixar coisar tag vazia!!!
    }

    public function addIcon($tags, $post)
    {
        foreach ($tags as $tag) {
            if ((strtolower($tag) == 'ajuda') || ($tag == 'Dúvida') || ($tag == 'socorro') || ($tag == 'pergunta') || ($tag == 'dúvida') || ($tag == 'duvida')) {
                $post->url_midia = 'images/place-help.jpg';
            } else
            if (strtolower($tag) == 'link') {
                $post->url_midia = 'images/place-link.jpg';
            } else {
                $post->url_midia = 'images/place-post.jpg';
            }

            $post->save();
        }
    }

    public function repost(Request $request)
    {
        $post1 = Post::where('id', $request->post_id)->first();
        $post1->num_reposts += 1;
        $post1->save();

        $post2              = new Post;
        $post2->user_id     = auth()->user()->id;
        $post2->titulo      = $post1->titulo;
        $post2->publicacao  = $post1->publicacao;
        $post2->is_publico  = $post1->is_publico;
        $post2->is_imagem   = $post1->is_imagem;
        $post2->is_video    = $post1->is_video;
        $post2->url_midia   = $post1->url_midia;
        $post2->is_repost   = true;
        $post2->id_repost   = $post1->id;
        $post2->user_repost = $post1->user_id;
        $post2->save();

        return Response::json(['id' => $post2->id, 'num' => $post1->num_reposts]);
    }

}
