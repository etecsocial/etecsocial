@foreach($posts as $post)
<div data-id="{{ $post->id }}" class="post blog col s12 m6 l4" style="margin-top: 20px">
    <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
            @if($post->is_imagem)
            <a href="{{ url($post->url_midia) }}" data-lightbox="img-post-1">
                <img src="{{ url($post->url_midia) }}">
            </a>
            @elseif($post->is_video)
            <video src="{{ url($post->url_midia) }}" controls style="width: 100%;height:265px;max-height: 265px"></video>      
            @else
            <img src="{{ url($post->url_midia) }}">
            @endif
        </div>
        <ul class="card-action-buttons">
            @if(App\Post::favoritou($post->id))
            @if($post->num_favoritos == 1)
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você favoritou"><i class="mdi-action-favorite-outline"></i></a>
            </li>
            @else
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você e outras {{ $post->num_favoritos - 1 }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a>
            @endif
            @else
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light red tooltipped" data-tooltip="{{ $post->num_favoritos }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a>
            </li>
            @endif
            @if($post->num_reposts == 1)
            <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoa compartilhou"><i class="mdi-social-share"></i></a></li>
            @else
            <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoas compartilharam"><i class="mdi-social-share"></i></a></li>
            @endif
            @if($post->num_comentarios == 1)
            <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoa comentou"><i class="mdi-communication-comment activator"></i></a>
            </li>
            @else
            <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoas comentaram"><i class="mdi-communication-comment activator"></i></a>
            @endif
        </ul>
        <div class="card-content">
            <p class="row">
                <span class="left">
                    @foreach(App\Tag::where('id_post', $post->id)->get() as $tag) 
                    <a href="{{ url("/tag/" . $tag->tag) }}">#{{ $tag->tag }}</a>
                    @endforeach

                    @if($post->is_repost) 
                    Compartilhado de <a href="{{ url(App\User::verUser($post->user_repost)->username) }}">{{ App\User::verUser($post->user_repost)->nome }}</a> 
                    @endif
                </span>
                <span class="right">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span>
            </p>
            <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $post->titulo }}</a>
            </h4>
            <p class="blog-post-content">{{ $post->publicacao }}</p>
        </div>
        <div class="row" id="autor-post">
            <div class="col s2">
                <img src="{{ App\User::avatar($post->id_user) }}" data-tooltip="Este é {{ $post->nome }}" class="circle responsive-img valign profile-image tooltipped">
            </div>
            <div class="col s6 m8"> 
                Por <a href="{{ url($post->username) }}">{{ $post->nome }}</a>
            </div>
            @if(Auth::user()->id == $post->id_user) 
            <a href="#modalExcluir" onclick="excluir({{ $post->id }})" class="wino"><i class="material-icons dropdown-button waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Excluir Publicação" data-delay="50" data-position="bottom">close</i></a>
            @else 
            <a href="#modalDenuncia" class="wino"><i class="material-icons dropdown-button waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Denunciar usuário" data-delay="50" data-position="bottom">turned_in</i></a>
            @endif
        </div>
        <div class="card-reveal">                                            
            <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
            <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                @foreach(App\Comentario::where('id_post', $post->id)->get() as $comentario)
                <li class="collection-item avatar" style="height: auto; min-height:65px;max-height: 100%">
                         @if(Auth::user()->id == $comentario->id_user) 
            <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
           
            @endif
                    <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
                    <p>{{ $comentario->comentario }}</p>
                </li>
                @endforeach           
            </ul>
            <div class="left row white" style="height: auto; bottom: 0px; width: 90%;">
                <div class="col s12">
                    <div class="input-field col s12">
                        <form method="POST" >
                            <input type="hidden" name="id_post" value="{{ $post->id }}" >
                            <input id="comentario-{{ $post->id }}" type="text" class="validate" autocomplete="off">
                            <label for="comment" class="">Comentar</label>
                            <button type="submit" onclick="return comentar({{ $post->id }});" class="waves-effect waves-light btn red">Comentar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach