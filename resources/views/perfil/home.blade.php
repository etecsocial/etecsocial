@extends('app')

@section('title')
{{ $user->nome_usuario }} {{ $user->sobrenome}} | ETEC Social
@stop

@section('style')
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
@stop

@section('jscript')
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/plugins/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/form.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src="js/plugins/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/plugins/sliders.js"></script>
<script type="text/javascript" src="js/plugins/succinct-master/jQuery.succinct.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src='js/script.js'></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script>
    function newpost() {
        var id_post = $(".post:first").data("idpost");
        var id_user = {{ $user->id }};

        $.post("/ajax/perfil/newpost", {id_post : id_post, id_user : id_user}, function (data) {
            $(data).insertBefore(".post:first").hide().fadeIn(2000);
        });
    }

    function morepost() {
        var id_post = $(".post:last").data("idpost");
        var n = $(".post").length;
         var id_user = {{ $user->id }};

        $.post("/ajax/perfil/morepost", {id_post : id_post, id_user : id_user, tamanho: n}, function (data) {
            if (data === '') {
                $('#loader-post').empty();
                loader = false;
            } else {
                $(data).insertAfter(".post:last").hide().fadeIn(1000);
            }
        });
    }

    var loader = true;

    $(window).scroll(function () {
        if (loader) {
            if ($(window).scrollTop() === $(document).height() - $(window).height()) {
                $('#loader-post').show();
                morepost();
            }
        }
        ç
    });

    $('#publicar').ajaxForm({
        dataType: 'JSON',
        success: function (data) {
            Materialize.toast('<span>Publicado com sucesso!</span>', 3000);
            $('#publicar')[0].reset();

            return newpost();
        },
        error: function (xhr) {
            Materialize.toast('<span>Escreva algo para publicar...</span>', 3000);
        }
    });

    function comentar(id_post) {
        var elem = "#comentarios-" + id_post;
        var comentario = document.getElementById("comentario-" + id_post).value;
          var id_comentario = $(".com-" + id_post + ":last").data("idpost");

        $.ajax({
            type: "POST",
            url: "/ajax/comentario",
              data: "id_post=" + id_post + "&id_comentario=" + id_comentario + "&comentario=" + comentario,
            dataType: "json",
            success: function (data) {
                $(elem).append(data.responseText);

                $("#comentario-" + id_post).val('');

               /* if (data.num === 1) {
                    $("#coment-" + id_post).attr({"data-tooltip": data.num + " pessoa comentou"});
                } else {
                    $("#coment-" + id_post).attr({"data-tooltip": data.num + " pessoas comentaram"});
                } */
            }
        });
        return false;
    }

    function favoritar(id_post) {
        var elem = "#favoritar-" + id_post;
        $.ajax({
            type: "POST",
            url: "/ajax/post/favoritar",
            data: "id_post=" + id_post,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    if (data.num === 0) {
                        $(elem).removeClass("red").addClass("grey").attr({"data-tooltip": "Você favoritou"});
                    } else {
                        $(elem).removeClass("red").addClass("grey").attr({"data-tooltip": "Você e outras " + data.num + " pessoas favoritaram"});
                    }
                } else {
                    $(elem).removeClass("grey").addClass("red").attr({"data-tooltip": data.num + " pessoas favoritaram"});
                }
            }
        });
        return false;
    }

    function repost(id_post) {
        $.ajax({
            type: "POST",
            url: "/ajax/repost",
            data: "id_post=" + id_post,
            dataType: "json",
            success: function (data) {
                Materialize.toast('Conteúdo compartilhado com sucesso.', 5000);
                newpost();

                if (data.num === 1) {
                    $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoa compartilhou"});
                } else {
                    $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoas compartilharam"});
                }
            }
        });
        return false;
    }

    function excluir(id_post) {
        $("#excluir").attr({"action": "post/" + id_post});
    }

    $('#excluir').ajaxForm({
        type: "DELETE",
        dataType: 'JSON',
        success: function (data) {
            if (data.status) {
                $('*[data-id="' + data.id + '"]').fadeOut(1000, function () {
                    this.remove();
                });
            } else {
                Materialize.toast('<span>Erro ao excluir publicação</span>', 3000);
            }
        }
    });
    
     function excluirComentario(id_comentario) {
        $("#excluirComentario").attr({"action": "/ajax/comentario/" + id_comentario });
    }

    $('#excluirComentario').ajaxForm({
        type: "DELETE",
        dataType: 'JSON',
        success: function (data) {
            if (data.status) {
                $('#com-' + data.id).fadeOut(1000, function () {
                    this.remove();
                });
            } else {
                Materialize.toast('<span>Erro ao excluir comentário</span>', 3000);
            }
        }
    });
</script>
@stop

@section('content')

@include('navFull')
<section id="content">
    <div class="container">
        <div id="profile-page" class="section">
            <div id="profile-page-header" class="card">
                <div class="card-image waves-effect waves-block waves-light hide-on-med-and-down">
                    <img class="activator" src="images/capa-perfil.jpg" alt="Perfil de {{ $user->nome_usuario }}" style="background-position: cover">
                </div>
                
                <figure class="card-profile-image hide-on-med-and-down" style="z-index: 2">
                    <a href="{{ App\User::avatar($user->id) }}" data-lightbox="ju">
                        <img src="{{ App\User::avatar($user->id) }}" class="circle z-depth-2 responsive-img activator">
                    </a>
                </figure>
                
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l2 offset-l2">
                            <h4 class="card-title grey-text text-darken-4">{{ $user->nome_usuario }} {{ $user->sobrenome}}</h4>
                            @if($user->tipo == 1)
                            <p class="medium-small grey-text tooltipped" data-tooltip="{{ $user->nome_curso }}" data-position="botton" data-delay="50">{{ explode(' ', App\User::infoAcademica($user->id)->modulo)[0] }} {{ $user->sigla }}</p>
                            @else
                             <p class="medium-small grey-text tooltipped" data-tooltip="{{ $infoacad->atuacao }}" data-position="botton" data-delay="50">{{ $infoacad->formacao }}</p>
                            @endif
                        </div>
                        <div class="col s12 l2">
                            <h4 class="card-title grey-text text-darken-4">{{ $user->reputacao }}</h4>
                            <p class="medium-small grey-text">Pontos de reputação</p>
                        </div>
                        <div class="col s12 l2">
                            <h4 class="card-title grey-text text-darken-4">{{ $user->num_desafios }}</h4>
                            <p class="medium-small grey-text">Desafios vencidos</p>
                        </div>
                        <div class="col s12 l2">
                            <h4 class="card-title grey-text text-darken-4">{{ $user->num_auxilios }}</h4>
                            <p class="medium-small grey-text">Auxílios prestados</p>
                        </div>
                        <div class="col s12 l2">
                            <h4 class="card-title grey-text text-darken-4">42</h4>
                            <p class="medium-small grey-text">Conteúdos postados</p>
                        </div>
                        
                    </div>
                </div>
              
                
            </div>
            <!--/ profile-page-header -->

            <!-- profile-page-content -->
            <div id="profile-page-content" class="row">
                <!-- profile-page-sidebar-->
                <div id="profile-page-sidebar" class="col s12 m4">
                    <!-- Profile About  -->
                    
                    @if($is_my)
                    
                    <div class="card green darken-1 white-text" style="height:150px">
                <div class="card-content">
                    <span class="card-title activator text-darken-4 white-text" onmouseover="javascript:$('#icon-edit-status').show('200')" onmouseout="javascript:$('#icon-edit-status').hide('200')"><i class="mdi-social-mood medium left white-text text-darken-4" style="margin-top:-5px"></i>Meu Status<i id="icon-edit-status" class="mdi-editor-mode-edit right" style="display:none"></i></span>
                    <div class="divider"></div>
                    @if(isset(Auth::user()->status))
                    <div id="us"><p class="left " style="margin-top:15px">{{{ Auth::user()->status }}}</p></div>
                    @else
                    <i class="left activator" style="margin-top:15px">Adicione um novo status. Clique aqui.</i>
                    @endif
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Atualizar Status <i class="mdi-navigation-close right"></i></span>
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
                    
                     <div class="card  red darken-1 white-text" style="height:258px">
                <div class="card-content">
                    <span class="card-title activator text-darken-4 white-text"><i class="mdi-social-mood medium left white-text text-darken-4" style="margin-top:-5px"></i>Status</span>
                    <div class="divider"></div>
                    @if(isset($user->status))
                    <div id="us"><p class="left " style="margin-top:15px">{{{ $user->status }}}</p></div>
                    @else
                    <i class="left activator" style="margin-top:15px">Não há status de {{ $user->nome_usuario}}.</i>
                    @endif
                </div>
                
            </div>
                    
                    
                    
                    @endif
                    
                    <!-- Profile About  -->
                     @if($amizade['status'])
                    <!-- Profile About Details  -->
                    <ul id="profile-page-about-details" class="collection z-depth-1">
                        @if(isset($user->empresa))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> {{ $user->cargo }}</div>
                                <div class="col s7 grey-text text-darken-4 right-align">na empresa {{ $user->empresa }}</div>
                            </div>
                        </li>
                        @endif
                        @if(isset($user->habilidades))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s5 grey-text darken-1"><i class="mdi-social-poll"></i> Habilidades</div>
                                <div class="col s7 grey-text text-darken-4 right-align">{{ $user->habilidades }}</div>
                            </div>
                        </li>
                        @endif
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i>Cadastro</div>
                                <div class="col s7 grey-text text-darken-4 right-align">{{$user->created_at->diffForHumans() }}</div>
                            </div>
                        </li>
                        @if(isset($infoacad))
                        @if($user->tipo === 2)
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s5 grey-text darken-1"><i class="mdi-social-school"></i> Leciona</div>
                                <div class="col s7 grey-text text-darken-4 right-align">{{ $infoacad->atuacao ? $infoacad->atuacao : '?' }}</div>
                            </div>
                        </li>
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> Formação</div>
                                <div class="col s7 grey-text text-darken-4 right-align">{{ $infoacad->formacao ? $infoacad->formacao : '?'}}</div>
                            </div>
                        </li>

                        @endif
                        @endif
                        @if(isset($user->cidade))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s4 grey-text darken-1"><i class="mdi-social-domain"></i> Mora em</div>
                                <div class="col s8 grey-text text-darken-4 right-align truncate">{{ $user->cidade }} - SP</div>
                            </div>
                        </li>
                        @endif
                        @if(isset($user->nome_etec))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s4 grey-text darken-1"><i class="mdi-social-school"></i> Unidade</div>
                                <div class="col s8 grey-text text-darken-4 right-align truncate" title="{{ $user->nome_etec }}">{{ $user->nome_etec }}</div>
                            </div>
                        </li>
                        @endif
                        @if(isset($user->nome_curso))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s4 grey-text darken-1"><i class="mdi-social-group"></i> Turma</div>
                                <div class="col s8 grey-text text-darken-4 right-align truncate">{{ explode(' ', App\User::infoAcademica($user->id)->modulo)[0] }} {{ $user->sigla }}</div>
                            </div>
                        </li>
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s4 grey-text darken-1"><i class="mdi-social-school"></i> Curso</div>
                                <div class="col s8 grey-text text-darken-4 right-align truncate" title="{{ $user->nome_curso }}">{{ $user->nome_curso }}</div>
                            </div>
                        </li>
                        @endif
                        @if(strtotime($user->nasc))
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s4 grey-text darken-1"><i class="mdi-social-cake"></i> Nascimento</div>
                                <div class="col s8 grey-text text-darken-4 right-align truncate">{{ Carbon\Carbon::parse($infos->nasc)->format("d/M/Y")   }}</div>
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
                    
@endif
                    <!-- Profile About  -->

                    <div class="row">
                        <div class="col s6">
                            <div class="card  cyan darken-2">
                                <div class="card-content white-text center-align">
                                    <p class="card-title"><i class="mdi-social-people"></i> {{ $num_amigos }}</p>
                                    <p>Amigos</p>
                                @if(!$is_my)
                                    @if($amizade['status'])
                                    <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-people tooltipped" data-tooltip="Vocês são amigos"></i></a>
                                    @else
                                    @if($amizade['error'] == "NAO_ACEITOU")
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light grey darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add 
                                                                                                                                                                  tooltipped" data-tooltip="Aguardando resposta a solicitação de amizade"></i></a>
                                     @endif
                                     @if($amizade['error'] == "VOCE_NAO_ACEITOU")
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light red darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aceitar solicitação de amizade"></i></a>
                                     @endif
                                     @if($amizade['error'] == "NAO_AMIGO")
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Enviar solicitação de amizade"></i></a>
                                     @endif
                                     @endif
                                     @endif
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="card  cyan darken-2">
                              <div class="card-content white-text center-align">
                                    <p class="card-title"><i class="mdi-social-group-add"></i> {{ $num_grupos }}</p>
                                    <p>Grupos</p>
                                    @if(!$is_my)
                                    <a style="margin-top: 3px" class="btn-floating waves-effect waves-light cyan darken-3" onclick="Materialize.toast('<span>Este recurso ainda está indisponível. Estamos trabalhando para disponibilizá-lo logo!</span>', 5000)"><i class="mdi-image-remove-red-eye"></i></a>
                                    @endif
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
                        <input type="checkbox" id="{{ $task->id }}" checked="checked" onclick="javascript:checkTask('{{ $task->id }}')">
                        @else
                        <input type="checkbox" id="{{ $task->id }}" onclick="javascript:checkTask('{{ $task->id }}')">
                        @endif
                        <label for="{{ $task->id }}">{{ $task->desc }}<a class="secondary-content"><span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span></a>
                        </label>
                        @if($task->data > time() + 3*24*60*60)
                        <span class="task-cat green darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                        @elseif($task->data > time())
                        <span class="task-cat yellow darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                        @else
                        <span class="task-cat red darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                        @endif
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
                        <ul class="tabs tab-profile cyan" style="width:100%;">
                            <li class="tab col s4"><a class="white-text waves-light">Postar conteúdos</a></li>
                        </ul>
                        <form method="post" id="publicar" action="{{ url('ajax/post') }}" class="tab-content col s12 grey lighten-4">
                            <div class="row">
                                <div class="col s2 hide-on-med-and-down">
                                    <img src="{{ App\User::myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post">
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
                                    <textarea name="publicacao"  class="materialize-textarea" class="validate tooltipped" data-tooltip="Procure ser objetivo. Use o icone de ajuda para macetes." data-delay="50" data-position="bottom"></textarea>
                                    <label for="publicacao">Poste um resumo, cite um autor, compartilhe algum conhecimento</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s4 m4 l2 share-icons">
                                    <a href="#modalMidia" class="wino tooltipped" data-tooltip="Adicionar mídia"><i class="mdi-maps-local-movies"></i></a>
                                    <a href="#modalAjuda" class="wino tooltipped" data-tooltip="Obter ajudar"><i class="mdi-action-help" ></i></a>
                                </div>
                                <div class="col s8 m3 l6">
                                    <div class="switch left">
                                        <label>Amigos
                                            <input type="checkbox" name="publico">
                                            <span class="lever tooltipped" data-tooltip="Quem pode ver isso?" data-delay="50" data-position="bottom"></span> Todos
                                        </label>
                                    </div>    
                                </div>
                                <div class="col s8 m8 l4 right-align">
                                    <button type="submit" class="waves-effect waves-light btn-flat red white-text"><i class="mdi-maps-rate-review right"></i>Publicar</button>
                                </div>
                            </div>
                            <div id="modalMidia" class="modal">
                                <div class="modal-content">
                                    <h5>Adicionar imagem ou vídeo</h5>
                                    <div class="file-field input-field">
                                        <input class="file-path validate" type="text"/>
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
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light grey darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aguardando resposta a solicitação de amizade"></i></a>
                                     @endif
                                     @if($amizade['error'] == "VOCE_NAO_ACEITOU")
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light red darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Aceitar solicitação de amizade"></i></a>
                                     @endif
                                     @if($amizade['error'] == "NAO_AMIGO")
                                     <a style="margin-top: 3px" class="add btn-floating waves-effect waves-light cyan darken-3" onclick="add({{ $user->id }})"><i class="add-icon mdi-social-person-add tooltipped" data-tooltip="Enviar solicitação de amizade"></i></a>
                                     @endif
                    </center>
                    <br>  
                               @endif
                    
                               




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
                                        <h5 class="timeline-post-title truncate" style="max-width: 100%">Compartilhou <i class="mdi-content-reply grey-text lighten-3"></i><span style="font-size: 1.0rem"> de <a href="{{ url(App\User::verUser($post->user_repost)->username) }}">{{ App\User::verUser($post->user_repost)->nome }}</a></span></h5>
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

                                                        
                                                    </span>
                                                    <span class="right">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->toFormattedDateString() }}</span>
                                                </p>
                                                <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $post->titulo }}</a>
                                                </h4>
                                                <p class="blog-post-content">{{ $post->publicacao }}</p>
                                                <div class="row" style="margin-top:10px">
                                                    <div class="col s2">
                                                        <img src="{{ App\User::avatar($post->id_user) }}" data-tooltip="Este é {{ $post->nome }}" class="circle responsive-img valign profile-image tooltipped">
                                                    </div>
                                                    <div class="col s9"> Por <a href="{{ url($post->username) }}">{{ $post->nome }}</a></div>
                                                    <i class="mdi-navigation-more-vert dropdown-button waves-effect waves-light" style="opacity: 0.7" href="#!" data-activates="dropdown1"></i>
                                                </div>
                                            </div>
                                            <div class="card-reveal">

                                                <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
                                                <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                                                    @foreach(App\Comentario::where('id_post', $post->id)->get() as $comentario)
                                                    <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $post->id }}" style="height: auto; min-height:65px;max-height: 100%"  data-id="{{ $comentario->id }}">
                                                         @if(Auth::user()->id == $comentario->id_user) 
            <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
          
            @endif
                                                       
                                                        <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
                                                        <p>{{ $comentario->comentario }}</p>
                                                    </li>
                                                    @endforeach           
                                                </ul> 

                                                <div class="left row white" style="height: auto; position: absolute; bottom: 0px; width: 90%">
                                                    <div class="col s12">
                                                        <div class="input-field col s12">
                                                            <form method="POST" >
                                                                <input type="hidden" name="id_post" value="{{ $post->id }}" >
                                                                <input id="comentario-{{ $post->id }}" type="text" class="validate" autocomplete="off">
                                                                <label for="comment" >Comentar</label>
                                                                <button type="submit" style="display:none" onclick="return comentar({{ $post->id }});" class="waves-effect waves-light btn red">Comentar</button>
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
    <form  id="excluir" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Publicação</h4>
            <p>Tem certeza que deseja excluir esse post?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>

<div id="modalExcluirComentario" class="modal">
    <form  id="excluirComentario" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Comentario</h4>
            <p>Tem certeza que deseja excluir esse comentario?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>
<div id="modalDenuncia" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><strong>Denunciar Publição</strong></h4><li class="divider"></li>
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
                                <input name="group1" type="radio" id="diz-ser-aluno" />
                                <label for="diz-ser-aluno">Aluno</label>
                                <input name="group1" type="radio" id="diz-ser-prof" />
                                <label for="diz-ser-prof">Professor</label>
                            </p>
                            <span><strong>O usuário é:</strong></span>
                            <p>
                                <input name="group2" type="radio" id="e-aluno" />
                                <label for="e-aluno">Aluno</label>
                                <input name="group2" type="radio" id="e-prof" />
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
                                    <input name="group3" type="radio" id="em-uma-pub" />
                                    <label for="em-uma-pub">Em uma publicação</label>
                                </p>
                                <p>
                                    <input name="group3" type="radio" id="em-uma-conv" />
                                    <label for="em-uma-conv">Em uma conversa</label>
                                </p>
                                <p>
                                    <input name="group3" type="radio" id="diadia"  />
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
            <a class="modal-action modal-close waves-effect waves-green btn-flat ">Denunciar</a>
        </div>
        <div><a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a></div>
    </div>
</div>


@stop