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
            <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} comentários"><i class="mdi-communication-comment activator"></i></a>
                @endif
        </ul>
        <div class="card-content">
            <p class="row">
                <span class="left">
                    @foreach($post->tags as $tag) 
                    <a href="{{ url("/tag/" . $tag->name) }}">#{{ $tag->name }}</a>
                    @endforeach
                    @if($post->is_repost) 
                    Compartilhado de <a href="{{ url(auth()->user()->verUser($post->user_id)->username) }}">{{ auth()->user()->verUser($post->user_id)->name }}</a>
                    @endif 
                </span>
            </p>
            <h4 class="card-title grey-text text-darken-4"><a href="{{ url('/') }}/post/{{$post->id}}" class="grey-text text-darken-4">{{ $post->titulo }}</a></h4>
            <section class="scroll-post-feed" style="overflow-y: auto; max-height: 200px">
                <p class="blog-post-content">{{ $post->publicacao }}</p>
            </section>
        </div>
        <div class="row" id="autor-post">
            <div class="col s2">
                <img src="{{ auth()->user()->avatar($post->user_id) }}" data-tooltip="Este é {{ $post->name }}" class="circle responsive-img valign profile-image tooltipped">
            </div>
            <div class="col s6 m8"> 
                @if($post->user_id == auth()->user()->id)
                Publicado por <a href="{{ url(auth()->user()->username) }}">você</a>
                @else
                Por <a href="{{ url($post->username) }}">{{ $post->name }} </a>
                @endif
                <span class="small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span> 
            </div>
            @if(auth()->user()->id == $post->user_id) 
            <a href="#modalExcluir" onclick="excluir({{ $post->id }})" class="wino"><i class="mdi-action-delete waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Excluir Publicação" data-delay="50" data-position="bottom"></i></a>
            <a href="#modalEditar" onclick="Materialize.toast('<span>Recurso em desenvolvimento.</span>', 3000)"><i class="mdi-editor-mode-edit waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Editar Publicação" data-delay="50" data-position="bottom"></i></a>
            @else 
            <a href="#modalDenuncia" onclick="denunciar({{ $post->id }})" class="wino"><i class="mdi-content-flag tooltipped waves-light" style="opacity: 0.7" data-tooltip="Denunciar Publicação" data-delay="50" data-position="bottom"></i></a>
            @endif
        </div>
        <div class="card-reveal">                                            
            <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
            <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                @foreach(App\Comentario::where('post_id', $post->id)->orderBy('relevancia', 'desc')->orderBy('created_at', 'desc')->get() as $comentario)
                <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $comentario->post_id }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">

                    @if(auth()->user()->id == $comentario->user_id) 

                    <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                    <i id="edita-comentario-{{ $comentario->id }}" onclick="exibeEditarComentario({{ $comentario->id }}, $('#com-{{ $comentario->id }}- text').text())" class="mdi-editor-mode-edit right tiny" style="color: #039be5; cursor: pointer"></i>
                    @else
                    <div id="relevancia-com-{{ $comentario->id }}">
                        @if($rv = App\RelevanciaComentarios::where('user_id', auth()->user()->id)->where('comentario_id', $comentario->id)->first())
                        @if($rv->relevancia == 'up')
                        <i class="mdi-hardware-keyboard-arrow-up right small-photo tooltipped" style="color: #039be5" data-tooltip='Avaliado como positivo'></i>                   
                        <i onclick="comentarioRel({{ $comentario->id }}, {{ $post->id }}, 'down')" class="mdi-hardware-keyboard-arrow-down right small-photo tooltipped" style="color: #ccc; cursor: pointer" data-tooltip='Avaliar como negativo'></i>
                        @else
                        <i onclick="comentarioRel({{ $comentario->id }}, {{ $post->id }}, 'up')" class="mdi-hardware-keyboard-arrow-up right small-photo tooltipped" style="color: #ccc; cursor: pointer" data-tooltip='Avaliar como positivo'></i>                   
                        <i class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #039be5"></i>                           
                        @endif
                        @else
                        <i onclick="comentarioRel({{ $comentario->id }}, {{ $post->id }}, 'up')" class="mdi-hardware-keyboard-arrow-up right small-photo tooltipped" style="color: #039be5; cursor: pointer" data-tooltip='Avaliar como positivo'></i>
                        <i onclick="comentarioRel({{ $comentario->id }}, {{ $post->id }}, 'down')" class="mdi-hardware-keyboard-arrow-down right small-photo tooltipped" style="color: #039be5; cursor: pointer" data-tooltip='Avaliar como negativo'></i>
                        @endif
                    </div>
                    @endif
                    <img src="{{ auth()->user()->avatar($comentario->user_id) }}" data-tooltip="Este é {{ auth()->user()->verUser($comentario->user_id)->name }}" class="circle tooltipped">
                    <p id="com-{{ $comentario->id }}-text">{{ $comentario->comentario }}</p>
                </li>
                @endforeach           
            </ul>
            <div class="left row white" style="height: auto; bottom: 0px; width: 90%;">
                <div class="col s12">
                    <div class="input-field col s12">
                        <form method="POST" onsubmit="return comentar({{ $post->id }});">
                            <input type="hidden" name="post_id" value="{{ $post->id }}" >
                            <input id="comentario-{{ $post->id }}" type="text" class="validate" autocomplete="off">
                            <label for="comment" >Comentar</label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>