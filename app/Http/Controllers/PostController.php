<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use App\Http\Controllers\Controller;

use DB;
use Input;
use Auth;

use App\Comentario;
use App\Post;
use App\Tag;
use App\User;

class PostController extends Controller
{  
    public $extensionImages = array('jpg', 'JPG', 'png', 'PNG');
    public $extensionVideos = array('flv', 'FLV', 'mp4', 'MP4');
    
    public $destinationPath = "midia/posts";

    /**
     * Middleware @Auth.
     *
     */
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {    
        $this->validate($request, [ 'publicacao' => 'required' ]);

        $post = new Post;
        $post->id_user = Auth::user()->id;
        if($request->titulo) {
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
                   
        return Response::json([ "id" => $post->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
         $post = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where("amizades.aceitou", 1)
                ->where("amizades.id_user2", Auth::user()->id)
                ->where("posts.id", $id)
                ->first();
         
         return view('post.post', [ 'post' => $post ]);
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
        if(isset($request->titulo)) $post->titulo = $request->titulo; else $post->titulo = "Sem título";
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
        
        if ($post->id_user !== Auth::user()->id) {
            return Response::json([ 'status' => false ]);
        }
        $post->delete();
        
        return Response::json([ 'status' => true, 'id' => $id ]);
    }
    
    public function favoritar(Request $request) 
    {
        $post = Post::where('id', $request->id_post)->first();

        try {
            DB::table('favoritos')
                    ->insert([ "id_post" => $request->id_post, "id_user" => Auth::user()->id]);
            
            $post->num_favoritos += 1;
            $post->save();

            return Response::json([ 'status' => true, 'num' => $post->num_favoritos - 1 ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                DB::table('favoritos')
                        ->where([ "id_post" => $request->id_post, "id_user" => Auth::user()->id])
                        ->delete();
                
                $post->num_favoritos -= 1;
                $post->save();

                return Response::json([ 'status' => false, 'num' => $post->num_favoritos ]);
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
            return "Erro ao adicionar mídia";
        }
      
        Input::file('midia')->move($this->destinationPath, md5($post->id));
        
        $post->url_midia = $this->destinationPath . '/' . md5($post->id);
        $post->save();
    }
    
    public function addTags($tags, $id_post) 
    {
        $array = str_replace('#', '', explode(" ", $tags));
        
        $n = (count($array) > 3) ? 3 : count($array);
        
        for ($i = 0; $i < $n; $i++) {
            Tag::create([ 'id_post' => $id_post, 'tag' => $array[$i] ]);
        }
        
        return $array;
    }
    
    public function addIcon($tags, $post) 
   {
        foreach($tags as $tag) {
            if ((strtolower($tag) == "duvida") OR ($tag == "Dúvida") OR ($tag == "dúvida")) {
                $post->url_midia = 'images/place-help.jpg';
            } else
            if (strtolower($tag) == "link") { 
                $post->url_midia = 'images/place-link.jpg';
            } else {
                $post->url_midia = 'images/place-post.jpg';
            }
            
            $post->save();
        }
    }
    
    public function repost(Request $request) 
    {
        $post1 = Post::where('id', $request->id_post)->first();
        $post1->num_reposts += 1;
        $post1->save();
        
        $post2 = new Post;
        $post2->id_user = Auth::user()->id;
        $post2->titulo = $post1->titulo;
        $post2->publicacao = $post1->publicacao;
        $post2->is_publico = $post1->is_publico;
        $post2->is_imagem = $post1->is_imagem;
        $post2->is_video = $post1->is_video;
        $post2->url_midia = $post1->url_midia;
        $post2->is_repost = true;
        $post2->id_repost = $post1->id;
        $post2->user_repost = $post1->id_user;
        $post2->save();
        
        return Response::json([ "id" => $post2->id, "num" => $post1->num_reposts ]);
    }
}
