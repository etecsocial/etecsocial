@extends('base')

@section('title')
{{ $user->name }} | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/style.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
'/js/plugins/lightbox-plus-jquery.min.js',
'/materialize-css/js/materialize.min.js',
'/js/form.min.js',

'/js/script.js',
'/js/plugins.js']) !!}
@include('perfil.partials._script')

@stop

@section('content')
@include('partials._nav')
<style>
    @media only screen and (max-width:600px) {
        .card-profile-image {
            top: 4% !important;
            left: 30% !important;
        }
        #profile-page-header .card-image {
            height: 160px
        }
    }
</style>
<div class="container">
    <div id="profile-page" class="section">
        <div id="profile-page-header" class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="images/capa-perfil.jpg" alt="Perfil de {{ $user->username }}" style="background-position: cover">
            </div>
            <figure class="card-profile-image" style="z-index: 2">
                <a href="{{ auth()->user()->avatar($user->id) }}" data-lightbox="ju">
                    <img src="{{ auth()->user()->avatar($user->id) }}" class="circle z-depth-2 responsive-img activator">
                </a>
            </figure>
            <div class="card-content">
                <div class="row">
                    <div class="col s12 l3 offset-l2">
                        <h4 class="card-title grey-text text-darken-4">{{ $user->name }}</h4> 
                        @if($user->type == 1)
                        <p class="medium-small grey-text tooltipped" data-tooltip="{{ $user->nome_curso }}" data-position="botton" data-delay="50">{{ explode(' ', $user->nome_curso)[0] }} {{ $user->sigla }}</p>
                        @else
                        <p class="medium-small grey-text tooltipped" data-tooltip="{{ $user->formacao }}" data-position="botton" data-delay="50">{{ $user->formacao }}</p>
                        @endif
                    </div>
                    <div class="col s4 l2">
                        <h4 class="card-title grey-text text-darken-4">0</h4>
                        <p class="medium-small grey-text">Pontos de reputação</p>
                    </div>
                    <div class="col s4 l2">
                        <h4 class="card-title grey-text text-darken-4">0</h4>
                        <p class="medium-small grey-text">Desafios vencidos</p>
                    </div>
                    <div class="col s1 right-align hide-on-med-and-down">
                        @if(!$is_my) @if($amizade['status'])
                        <a class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-people tooltipped" data-tooltip="Vocês são amigos"></i></a> @else @if($amizade['error'] == "NAO_ACEITOU")
                        <a class="add btn-floating waves-effect waves-light grey darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add 
                                                                                                                             tooltipped" data-tooltip="Aguardando resposta a solicitação de amizade"></i></a> @endif @if($amizade['error'] == "VOCE_NAO_ACEITOU")
                        <a class="add btn-floating waves-effect waves-light red darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aceitar solicitação de amizade"></i></a> @endif @if($amizade['error'] == "NAO_AMIGO")
                        <a class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Enviar solicitação de amizade"></i></a> @endif @endif @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="profile-page-content" class="row">
            <div id="profile-page-sidebar" class="col s12 m4">
                @if($is_my)
                <div class="card yellow darken-2 white-text" style="height:150px">
                    <div class="card-content">
                        <span class="card-title activator text-darken-4 white-text" onmouseover="javascript:$('#icon-edit-status').show('200')"><i class="mdi-social-mood medium left white-text text-darken-4" style="margin-top:-5px"></i>Meu Status<i id="icon-edit-status" class="mdi-editor-mode-edit right" style="display:none"></i></span>
                        <div class="divider"></div>
                        @if(isset(auth()->user()->status))
                        <div id="us">{{{ auth()->user()->status }}}</div>
                        @else
                        <i class="left activator" style="margin-top:15px">Adicione um novo status. Clique aqui.</i> @endif
                    </div>
                    <div class="card-reveal">
                        <div class="input-field col s12 accent-4">
                            <form method="POST" action="{{ url('ajax/status') }}" id="status">
                                <input id="status" name="status" type="text" class="validate" autocomplete="off" style="color:black">
                                <label for="status">Novo status</label>
                                <button type="submit" style="font-size:14px" class="card-title waves-effect waves-light btn red">Atualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="card orange darken-1 white-text" style="height:258px">
                    <div class="card-content">
                        <span class="card-title activator text-darken-4 white-text"><i class="mdi-social-mood medium left white-text text-darken-4" style="margin-top:-5px"></i>Status</span>
                        <div class="divider"></div>
                        @if(isset($user->status))
                        <div id="us">
                            <p class="left " style="margin-top:15px">{{{ $user->status }}}</p>
                        </div>
                        @else
                        <i class="left activator" style="margin-top:15px">Não há status de {{ $user->nome_usuario}}.</i> @endif
                    </div>
                </div>
                @endif
                <!-- Profile About  -->
                <!-- Profile About Details  -->
                <ul id="profile-page-about-details" class="collection z-depth-1">
                    @if(isset($user->empresa))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> {{ $user->cargo }}</div>
                            <div class="col s7 grey-text text-darken-4 right-align">na empresa {{ $user->empresa }}</div>
                        </div>
                    </li>
                    @endif @if(isset($user->habilidades))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s5 grey-text darken-1"><i class="mdi-social-poll"></i> Habilidades</div>
                            <div class="col s7 grey-text text-darken-4 right-align">{{ $user->habilidades }}</div>
                        </div>
                    </li>
                    @endif
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> <span class="hide-on-small-only">Cadastro</span></div>
                            <div class="col s7 grey-text text-darken-4 right-align">{{$user->created_at->diffForHumans() }}</div>
                        </div>
                    </li>
                    @if(isset($infoAcad)) @if($user->tipo === 2)
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> Formação</div>
                            <div class="col s7 grey-text text-darken-4 right-align">{{ $user->formacao ? $user->formacao : '?'}}</div>
                        </div>
                    </li>
                    @endif @endif @if(isset($user->cidade))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i class="mdi-social-domain"></i> Mora em</div>
                            <div class="col s8 grey-text text-darken-4 right-align truncate">{{ $user->cidade }} - SP</div>
                        </div>
                    </li>
                    @endif @if(isset($user->nome_etec))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i class="mdi-social-school"></i> <span class="hide-on-small-only">Unidade</span></div>
                            <div class="col s8 grey-text text-darken-4 right-align truncate" title="{{ $user->nome_etec }}">{{ $user->nome_etec }}</div>
                        </div>
                    </li>
                    @endif @if(isset($user->nome_curso))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i class="mdi-social-group"></i> <span class="hide-on-small-only">Turma</span></div>
                            <div class="col s8 grey-text text-darken-4 right-align truncate">{{ explode(' ', $user->nome_curso)[0] }} {{ $user->sigla }}</div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i class="mdi-social-school"></i> <span class="hide-on-small-only">Curso</span></div>
                            <div class="col s8 grey-text text-darken-4 right-align truncate" title="{{ $user->nome_curso }}">{{ $user->nome_curso }}</div>
                        </div>
                    </li>
                    @endif @if(strtotime($user->nascimento))
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i class="mdi-social-cake"></i> Nascimento</div>
                            <div class="col s8 grey-text text-darken-4 right-align truncate">{{ Carbon\Carbon::parse($infos->nascimento)->format("d/M/Y") }}</div>
                        </div>
                    </li>
                    @endif
                </ul>
                <!--/ Profile About Details  -->
                <!-- Profile About Details  -->
                <!--                    <ul id="profile-page-about-details" class="collection z-depth-1">
               <li class="collection-item">
                   Não há outras informações.
               </li>                        
               </ul>-->
                <!--/ Profile About Details  -->
                <!-- Profile About  -->
                <div class="row">
                    <div class="col s6">
                        <div class="card  cyan darken-2">
                            <div class="card-content white-text center-align">
                                <p class="card-title"><i class="mdi-social-people"></i> {{ $num_amigos }}</p>
                                <p>Amigos</p>
                                @if(!$is_my) @if($amizade['status'])
                                <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-people tooltipped" data-tooltip="Vocês são amigos"></i></a> @else @if($amizade['error'] == "NAO_ACEITOU")
                                <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light grey darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add 
                                                                                                                                                             tooltipped" data-tooltip="Aguardando resposta a solicitação de amizade"></i></a> @endif @if($amizade['error'] == "VOCE_NAO_ACEITOU")
                                <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light red darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aceitar solicitação de amizade"></i></a> @endif @if($amizade['error'] == "NAO_AMIGO")
                                <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Enviar solicitação de amizade"></i></a> @endif @endif @endif
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="card  cyan darken-2">
                            <div class="card-content white-text center-align">
                                <p class="card-title"><i class="mdi-social-group-add"></i> {{ $num_grupos }}</p>
                                <p>Grupos</p>
                                @if(!$is_my)
                                <a style="margin-top: 3px" class="btn-floating waves-effect waves-light cyan darken-3" onclick="Materialize.toast('<span>Este recurso ainda está indisponível. Estamos trabalhando para disponibilizá-lo logo!</span>', 5000)"><i class="mdi-image-remove-red-eye"></i></a> @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if($is_my)
                <ul id="task-card" class="collection with-header">
                    <li class="collection-header cyan bg-card-tasks">
                        <h4 class="task-card-title">Minhas Tarefas</h4>
                        <p class="task-card-date">{{ \Carbon\Carbon::now()->formatLocalized('%A %d %B %Y') }}</p>
                    </li>
                    @foreach($tasks as $task)
                    <li class="tarefa collection-item dismissable" data-id="{{ $task->id }}" data-date="{{ $task->data }}">
                        @if($task->checked)
                        <input type="checkbox" id="{{ $task->id }}" checked="checked" onclick="javascript:checkTask('{{ $task->id }}')"> @else
                        <input type="checkbox" id="{{ $task->id }}" onclick="javascript:checkTask('{{ $task->id }}')"> @endif
                        <label for="{{ $task->id }}">{{ $task->desc }}<a class="secondary-content"><span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span></a>
                        </label>
                        @if($task->data > time() + 3*24*60*60)
                        <span class="task-cat green darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @elseif($task->data > time())
                        <span class="task-cat yellow darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @else
                        <span class="task-cat red darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @endif
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div id="profile-page-wall" class="col s12 m8">
                @if($is_my)
                <!-- profile-page-wall-share -->
                <div id="profile-page-wall-share" class="row">
                    <div class="col s12">
                        <ul class="tabs tab-profile cyan">
                            <li class="tab col s4"><a class="white-text waves-light">Postar conteúdos</a></li>
                        </ul>
                        <form method="post" id="publicar" action="{{ url('ajax/post') }}" class="tab-content col s12 grey lighten-4">
                            <div class="row">
                                <div class="col s2 hide-on-med-and-down">
                                    <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post">
                                </div>
                                <div class="input-field col s6 l6">
                                    <input name="titulo" type="text" class="validate tooltipped" data-tooltip="O assunto deve ser coerente." data-delay="50" data-position="bottom">
                                    <label for="titulo">Assunto</label>
                                </div>
                                <div class="input-field col s6 l4">
                                    <input name="tags" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="Use no máximo 3 tags, sepadas por espaço." data-delay="50" data-position="bottom">
                                    <label for="tags">Tags (opcional)</label>
                                </div>
                                <div class="input-field col s12 l10">
                                    <textarea name="publicacao" class="materialize-textarea" class="validate tooltipped" data-tooltip="Procure ser objetivo. Use o icone de ajuda para macetes." data-delay="50" data-position="bottom"></textarea>
                                    <label for="publicacao">Poste um resumo, cite um autor, compartilhe algum conhecimento</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s2 m4 l2 share-icons">
                                    <a href="#modalMidia" class="wino tooltipped" data-tooltip="Adicionar mídia"><i class="mdi-maps-local-movies"></i></a>
                                    <a href="#modalAjuda" class="wino tooltipped hide-on-small-only" data-tooltip="Obter ajudar"><i class="mdi-action-help" ></i></a>
                                </div>
                                <div class="col s8 l5">
                                    <div class="switch left">
                                        <label>Amigos
                                            <input type="checkbox" name="publico">
                                            <span class="lever tooltipped" data-tooltip="Quem pode ver isso?" data-delay="50" data-position="botom"></span> Todos
                                        </label>
                                    </div>
                                </div>
                                <div class="col s2 l2">
                                    <button type="submit" data-tooltip="Publicar" data-delay="50" data-position="botom" class="tooltipped waves-effect waves-light btn-flat red white-text"><i class="mdi-maps-rate-review"></i></button>
                                </div>
                            </div>
                            <div id="modalMidia" class="modal">
                                <div class="modal-content">
                                    <h5>Adicionar imagem ou vídeo</h5>
                                    <div class="file-field input-field">
                                        <input class="file-path validate" type="text" />
                                        <div class="btn">
                                            <span>+</span>
                                            <input type="file" name="midia" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
                                </div>
                            </div>
                        </form>
                        <div id="modalAjuda" class="modal">
                            <div class="modal-content">
                                <h4>Ajuda</h4>
                                <p>Caso queira perguntar algo, adcione a Tag "ajuda". Para links, utilize a "link". </p>
                            </div>
                            <div class="modal-footer">
                                <a class=" modal-action modal-close waves-effect waves-green btn-flat">Ok, entendi</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--/ profile-page-wall-share -->
                <!-- profile-page-wall-posts -->
                <div id="profile-page-wall-posts" class="row">
                    <!--/ INICIO TIMELINE -->
                    <section class="timeline" style="margin-top: 30px">
                        @if(!$amizade['status'])
                        <br>
                        <center>
                            @if($amizade['error'] == "NAO_ACEITOU")
                            <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light grey darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aguardando resposta a solicitação de amizade"></i></a> @endif @if($amizade['error'] == "VOCE_NAO_ACEITOU")
                            <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light red darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aceitar solicitação de amizade"></i></a> @endif @if($amizade['error'] == "NAO_AMIGO")
                            <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Enviar solicitação de amizade"></i></a> @endif
                        </center>
                        <br> @endif
                        @foreach ($posts as $post)
                        <!--/ INICIO HISTÓRIA -->
                        <div class="post timeline-block" data-idpost="{{ $post->id }}">
                            @if($post->is_repost)
                            <div class="timeline-icon light-green lighten-1 white-text">
                                <i class="ion mdi-social-share"></i>
                            </div>
                            <!-- content -->
                            <div class="timeline-content">
                                <!-- Inicio Publicação com foto ou video-->
                                <section class="blog col s12">

                                    <h5 class="timeline-post-title truncate" style="max-width: 100%">Compartilhou <i class="mdi-content-reply grey-text lighten-3"></i><span style="font-size: 1.0rem"> de <a href="{{ url(auth()->user()->verUser($post->user_repost)->username) }}">{{ auth()->user()->verUser($post->user_repost)->name }}</a></span></h5>

                                    @else
                                    <div class="timeline-icon light-green lighten-1 white-text">
                                        <i class="ion mdi-editor-mode-edit"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <section class="blog col s12">
                                            <h5 class="timeline-post-title">Publicou</h5> 
                                            @endif
                                            <!-- content -->
                                            <div class="divider" style="margin-top:3px"></div>
                                            <div class="card">
                                                <div class="card-image waves-effect waves-block waves-light">
                                                    @if($post->is_imagem)
                                                    <a href="{{ url($post->url_midia) }}" data-lightbox="img-post-1">
                                                        <img src="{{ url($post->url_midia) }}">
                                                    </a> @elseif($post->is_video)
                                                    <video src="{{ url($post->url_midia) }}" controls style="width: 100%;height:265px;max-height: 265px"></video>
                                                    @else
                                                    <img src="{{ url($post->url_midia) }}"> @endif
                                                </div>
                                                <ul class="card-action-buttons">
                                                    @if(App\Post::favoritou($post->id)) @if($post->num_favoritos == 1)
                                                    <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você favoritou"><i class="mdi-action-favorite-outline"></i></a>
                                                    </li>
                                                    @else
                                                    <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você e outras {{ $post->num_favoritos - 1 }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a> @endif @else
                                                    <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light red tooltipped" data-tooltip="{{ $post->num_favoritos }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a>
                                                    </li>
                                                    @endif @if($post->num_reposts == 1)
                                                    <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoa compartilhou"><i class="mdi-social-share"></i></a></li>
                                                    @else
                                                    <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoas compartilharam"><i class="mdi-social-share"></i></a></li>
                                                    @endif @if($post->num_comentarios == 1)
                                                    <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoa comentou"><i class="mdi-communication-comment activator"></i></a>
                                                    </li>
                                                    @else
                                                    <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoas comentaram"><i class="mdi-communication-comment activator"></i></a> @endif
                                                </ul>
                                                <div class="card-content">
                                                    <p class="row">
                                                        <span class="left">
                                                            @foreach($post->tags as $tag) 
                                                            <a href="{{ url("/tag/" . $tag->name) }}">#{{ $tag->name }}</a>
                                                            @endforeach

                                                        </span>
                                                    </p>
                                                    <h4 class="card-title grey-text text-darken-4"><a href="{{ url('/') }}/post/{{$post->id}}" class="grey-text text-darken-4">{{ $post->titulo }}</a></h4>
                                                    <section class="scroll-post-feed" style="overflow-y: auto; max-height: 200px">
                                                        <p class="blog-post-content">{{ $post->publicacao }}</p>
                                                    </section>
                                                </div>


                                                <div class="card-reveal">                                            
                                                    <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
                                                    <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                                                        @forelse($post->comentarios as $comentario)
                                                        <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $comentario->post_id }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">

                                                            @if(auth()->user()->id == $comentario->user_id) 

                                                            <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                                                            <i id="edita-comentario-{{ $comentario->id }}" onclick="exibeEditarComentario({{ $comentario->id }}, $('#com-{{ $comentario->id }}- text').text())" class="mdi-editor-mode-edit right tiny" style="color: #039be5; cursor: pointer"></i>
                                                            @else
                                                            <div id="relevancia-com-{{ $comentario->id }}">
                                                                @if($rv = App\RelevanciaComentarios::where('id_usuario', auth()->user()->id)->where('comentario_id', $comentario->id)->first())
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
                                                        @empty
                                                        <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $comentario->post_id }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">
                                                            <p>Ninguém comentou esta publicação ainda.</p>
                                                        </li>
                                                        @endforelse           
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
                                        </section>
                                        <!-- Fim Publicação com foto ou video-->
                                        <span class="timeline-date">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span>
                                    </div>
                                    <!-- content -->
                            </div>
                            <!--/ FIM HISTÓRIA -->
                            @endforeach 
                            @if(empty($posts[0]))
                            <div class="post timeline-block" data-idpost="0"></div>
                            @endif
                    </section>
                    <!--/ FIM TIMELINE -->
                </div>
                <!--/ profile-page-wall-posts -->
                @if($amizade['status'])
                <div class="row" id="loader-post" style="display:none">
                    <div class="col s12 m4 center" style="margin-top: 30px">
                    </div>
                    <div class="col s12 m4 center">
                        <div class="preloader-wrapper big active" style="margin-top: 30px">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4 center">
                    </div>
                </div>
                @endif
            </div>
            <!--/ profile-page-wall -->
        </div>
    </div>
</div>
</div>
<!--end container-->
</section>
<div id="modalExcluir" class="modal">
    <form id="excluir" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Publicação</h4>
            <p>Tem certeza que deseja excluir esse post?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Excluir</button>
        </div>
    </form>
</div>
<div id="modalExcluirComentario" class="modal">
    <form id="excluirComentario" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Comentario</h4>
            <p>Tem certeza que deseja excluir esse comentario?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Excluir</button>
        </div>
    </form>
</div>
<div id="modalDenuncia" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><strong>Denunciar Publição</strong></h4>
        <li class="divider"></li>
        <p>O que está havendo?</p>
        <div class="painel">
            <div class="painelTitle" style="margin-top:15px">
                Selecione uma opção
            </div>
            <div class="painelContent">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header">Está se passando por alguém</div>
                        <div class="collapsible-body">
                            <p>
                                <input name="group1" type="radio" id="noAcc" style="padding-left: 25px;border: 2px solid red;background: red!important">
                                <label for="noAcc">Ele não tem uma conta</label>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">Não é o que diz ser</div>
                        <div class="collapsible-body">
                            <span><strong>O usuário diz ser:</strong></span>
                            <p>
                                <input name="group1" type="radio" id="diz-ser-aluno">
                                <label for="diz-ser-aluno">Aluno</label>
                                <input name="group1" type="radio" id="diz-ser-prof">
                                <label for="diz-ser-prof">Professor</label>
                            </p>
                            <span><strong>O usuário é:</strong></span>
                            <p>
                                <input name="group2" type="radio" id="e-aluno">
                                <label for="e-aluno">Aluno</label>
                                <input name="group2" type="radio" id="e-prof">
                                <label for="e-prof">Professor</label>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">Não é verdadeiro</div>
                        <div class="collapsible-body">
                            <span><strong>Onde Juninho faltou com a verdade?</strong></span>
                            <form action="#">
                                <p>
                                    <input name="group3" type="radio" id="em-uma-pub">
                                    <label for="em-uma-pub">Em uma publicação</label>
                                </p>
                                <p>
                                    <input name="group3" type="radio" id="em-uma-conv">
                                    <label for="em-uma-conv">Em uma conversa</label>
                                </p>
                                <p>
                                    <input name="group3" type="radio" id="diadia">
                                    <label for="diadia">No dia a dia</label>
                                </p>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div>
            <a class="modal-action modal-close waves-effect waves-green btn-flat">Denunciar</a>
        </div>
        <div>
            <a class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
        </div>
    </div>
</div>
@stop
