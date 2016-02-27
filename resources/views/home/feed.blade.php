@extends('app')
@section('title')
ETEC Social
@stop

@section('style')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="/css/asset.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/js/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet">
@stop

@section('jscript')
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/js/plugins/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="/js/materialize.js"></script>
<script type="text/javascript" src="/js/form.min.js"></script>
<script type="text/javascript" src="/js/jquery.tagsinput.min.js"></script>

<script type="text/javascript" src="/js/plugins/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="/js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src="/js/plugins/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/js/plugins/sliders.js"></script>
<script type="text/javascript" src="/js/plugins/succinct-master/jQuery.succinct.min.js"></script>

<script type="text/javascript" src="/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="/js/plugins/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript" src="/js/plugins/fullcalendar/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="/js/plugins/fullcalendar/fullcalendar-script.js"></script>

<script type="text/javascript" src='/js/script.js'></script>
<script type="text/javascript" src="/js/plugins.js"></script>
<script>
function newpost() {
    var post_id = $(".post:first").data("id");

    $.post("/ajax/newpost", {id: post_id}, function (data) {
        $(data).insertBefore(".post:first").hide().fadeIn(2000);
    });
}

function morepost() {
    var post_id = $(".post:last").data("id");
    var n = $(".post").length;

    $.post("/ajax/morepost", {id: post_id, tamanho: n}, function (data) {
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
    var id_comentario = $(".com-" + id_post + ":last").data("id");
    var comentario = document.getElementById("comentario-" + id_post).value;

    $.ajax({
        type: "POST",
        url: "/ajax/comentario",
        data: "id_post=" + id_post + "&id_comentario=" + id_comentario + "&comentario=" + comentario,
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast('Digite algo para comentar.', 5000);
                return false
            } else {
                $(elem).append(data.responseText);
                $("#comentario-" + id_post).val('');
            }
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
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você favoritou"});
                } else {
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você e outras " + data.num + " pessoas favoritaram"});
                }
            } else {
                $(elem).removeClass("grey")
                        .addClass("red")
                        .attr({"data-tooltip": data.num + " pessoas favoritaram"});
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
    $("#excluir").attr({"action": "/ajax/post/" + id_post});
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

function excluirComentario(id_post, id_comentario) {
    $("#excluirComentario").attr({"action": "/ajax/comentario/" + id_comentario});
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

@if($id)
<script>$("#verpost").openModal(); abrirPost({{ $id }})</script>
@endif

@stop

@section('content')

@include('nav')
<section id="content">
    <div class="container">
        <div id="chart-dashboard">
            <div class="row">
                <div class="col s12 m12 l8" style="margin-bottom: 30px">
                    <div id="calendar-widget"></div>
                </div>
                <div class="col s12 m12 l4">
                    <ul id="task-card" class="collection with-header">
                        <li class="collection-header color-pri">
                            <h4 class="task-card-title">Minhas Tarefas <i class="fa fa-tasks right"></i></h4>
                            <p class="task-card-date">{{ \Carbon\Carbon::now()->formatLocalized('%A %d %B %Y') }}</p>
                        </li>
                        @if(isset($tasks[0]))
                        @foreach($tasks as $task)
                        <li class="tarefa collection-item dismissable" data-idtask="{{ $task->id }}" data-date="{{ $task->data }}">
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
                        @else 
                        <li class="tarefa collection-item dismissable">
                            <p class="center-align">Você não ainda não criou nenhuma tarefa!</p>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card-rss-header color-pri white-text">Vestibulando <i style="margin-top: 5px; margin-right: 3px;" class="mdi-maps-local-library right small center white-text"></i></div>
                    <ul class="white-text bxslider width-percent-100" data-bx-slider-pager="false" data-bx-slider-controls="false" data-bx-slider-auto="true" data-bx-slider-mode="vertical" style="margin-top: -10px; height: 150px; width: auto; position: absolute; -webkit-transition-duration: 0s; transition-duration: 0s; -webkit-transform: translate3d(0px, -254px, 0px);">
                        <li style="float: none; list-style: none; position: relative; width: 261px;" class="bx-clone">
                            <div class="card-rss card color-pri-light title card-social material-animate material-animated" style="-webkit-animation-delay: 0.35s; animation-delay: 0.35s;">

                                <div class="title">Conheça os 34 tipos de Engenharia que existem</div>
                                <div class="card-corpo">
                                    <p style="max-height: 80px; overflow-y: auto">"Gosta da área de exatas? Cálculos e ciência são suas paixões? Então com certeza Engenharia seria uma ótima opção para você!

Cada graduação tem características e perfis próprios. Listamos todas as engenharias para você acabar com suas dúvidas e escolher a área que mais lhe interessa. Confira.
"</p>
                                </div>
                                <div class="card-footer">
                                    <a target="_blank" href="http://guiadoestudante.abril.com.br/vestibular-enem/conheca-34-tipos-engenharia-existem-602301.shtml">Clique para continuar lendo.</a>
                                </div>
                            </div>
                        </li>
                        <li style="float: none; list-style: none; position: relative; width: 261px;">
                            <div class="card-rss card color-pri-light title card-social material-animate material-animated" style="-webkit-animation-delay: 0.35s; animation-delay: 0.35s;">
                                <div class="title">Cadernos de prova da Unicamp 2016 já estão disponíveis</div>
                                <div class="card-corpo">
                                    <p style="max-height: 80px; overflow-y: auto">"As provas do vestibular 2016 da Universidade Estadual de Campinas (Unicamp) já estão disponíveis para consulta. A prova, que continha 90 questões de múltipla escolha com todo o conteúdo do ensino médio, foi aplicada neste domingo (22). "</p>
                                    <div id="rsss"></div>
                                </div>
                                <div class="card-footer">
                                    <a target="_blank" href="http://guiadoestudante.abril.com.br/vestibular-enem/cadernos-prova-unicamp-2016-ja-estao-disponiveis-923002.shtml">Clique para continuar lendo.</a>
                                </div>
                            </div>
                        </li>
                        <li style="float: none; list-style: none; position: relative; width: 261px;">
                            <div class="card-rss card color-pri-light title card-social material-animate material-animated" style="-webkit-animation-delay: 0.35s; animation-delay: 0.35s;">
                                <div class="title">Fuvest 2016: Maioria dos inscritos vem de escola particular</div>
                                <div class="card-corpo">
                                    <p style="max-height: 80px; overflow-y: auto">"Na tarde desta quinta-feira (19), a Fundação Universitária para o Vestibular (Fuvest) divulgou o Questionário Socioeconômico do vestibular 2016. Os mais de 142,6 mil inscritos para o processo seletivo da Universidade de São Paulo (USP) e para a Faculdade de Ciências Médicas da Santa Casa responderam perguntas como sexo, renda familiar e raça."</p>
                                    <div id="rsss"></div>
                                </div>
                                <div class="card-footer">
                                    <a target="__blank" href="http://guiadoestudante.abril.com.br/vestibular-enem/fuvest-2016-maioria-inscritos-vem-escola-particular-922681.shtml">Clique para continuar lendo.</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="col s12 m12 l4">
                    <div class="card  light-blue">
                        <div class="left">
                            <img src="/images/icon-insights.png" class="left bg-infos" alt="Reputação" style="margin-left: 0">
                        </div>
                        <div class="right">
                            <p class="num-infos">{{ Auth::user()->reputacao }}</p>
                            <p class="white-text text-infos">Reputação</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card  light-blue">
                        <div class="left">
                            <img src="/images/icon-desafio.png" class="left bg-infos" alt="Desafios">
                        </div>
                        <div class="right">
                            <p class="num-infos">{{ Auth::user()->num_desafios }}</p>
                            <p class="white-text text-infos">Desafios vencidos</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card  light-blue">
                        <div class="left">
                            <img src="/images/icon-help.png" class="left bg-infos" alt="Auxílios" style="margin-left: 0">
                        </div>
                        <div class="right">
                            <p class="num-infos">{{ Auth::user()->num_auxilios }}</p>
                            <p class="white-text text-infos">Auxíliou</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="row">
        <div class="col s12 m4">
            <div class="card red lighten-2 white-text" style="min-height:250px">
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
                    <p class="grey-text">Há algo novo para compartilhar com seus amigos, {{ Auth::user()->nome }}?</p>
                    <div class="input-field col s12 accent-4">
                        <form method="POST" action="{{ url('ajax/status') }}" id="status">      
                            <input id="status" name="status" type="text" class="validate" autocomplete="off" style="color:black">
                            <label for="status" class="">Novo Status</label>
                            <button type="submit" style="font-size:14px" class="card-title waves-effect waves-light btn red">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m8">
            <div id="profile-page-wall-share" class="row">
                <div class="col s12">
                    <ul class="tabs tab-profile z-depth-1 light-blue" style="width:100%;">
                        <li class="tab col s4"><a class="white-text waves-light ">Postar conteúdos</a></li>
                    </ul>
                    <form method="post" id="publicar" action="{{ url('ajax/post') }}" class="tab-content col s12 grey lighten-4">
                        <div class="row">
                            <div class="col s2">
                                <img src="{{ App\User::myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post">
                            </div>
                            <div class="input-field col s5">
                                <input name="titulo" placeholder="Assunto (título)" spellcheck="true" autocomplete="off" type="text" class="validate tooltipped" data-tooltip="O assunto deve ser coerente." data-delay="50" data-position="bottom">
                            </div>
                            <div class="input-field col s5">
                                <input name="tags" placeholder="tags (opcional)" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="Use no máximo 3 tags, sepadas por espaço." data-delay="50" data-position="bottom">
                            </div>
                            <div class="input-field col s10">
                                <textarea name="publicacao" placeholder="Poste um resumo, cite um autor, compartilhe algum conhecimento" class="validate tooltipped" data-tooltip="Procure ser objetivo. Use o icone de ajuda para macetes." data-delay="50" data-position="bottom"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m4 share-icons">
                                <a href="#modalMidia" class="wino tooltipped" data-tooltip="Adicionar mídia"><i class="mdi-maps-local-movies"></i></a>
                                <a href="#modalAjuda" class="wino tooltipped" data-tooltip="Obter ajudar"><i class="mdi-action-help" ></i></a>
                            </div>
                            <div class="col s12 m8 right-align">
                                <div class="switch left">
                                    <label>Amigos
                                        <input type="checkbox" name="publico">
                                        <span class="lever tooltipped" data-tooltip="Quem pode ver isso?" data-delay="50" data-position="bottom"></span> Todos
                                    </label>
                                </div>
                                <button type="submit" class="waves-effect waves-light btn red"><i class="mdi-maps-rate-review right"></i>Publicar</button>
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
        </div>
        </div>
    </div>
    <div id="card-widgets" class="seaction">
        <div class="row">
            <div class="col s12" id="post">
                @foreach($posts as $post)
                <div data-id="{{ $post->id }}" class="blog post col s12 m6 l4" style="margin-top: 20px">
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
                                    De <a href="{{ url(App\User::verUser($post->user_repost)->username) }}">{{ App\User::verUser($post->user_repost)->nome }}</a> 
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
                            
                           <!-- <a href="#modalDenuncia" class="wino"><i class="material-icons dropdown-button waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Denunciar usuário" data-delay="50" data-position="bottom">turned_in</i></a> -->
                            @endif
                        </div>
                        <div class="card-reveal">                                            
                            <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
                            <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                                @foreach(App\Comentario::where('id_post', $post->id)->get() as $comentario)
                                <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $post->id }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">

                                    @if(Auth::user()->id == $comentario->id_user) 
                                    <a href="#modalExcluirComentario" onclick="excluirComentario({{ $post->id }}, {{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>

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
                @if(!isset($posts[0]))
                <div data-id="0" class="post blog col s12 m6 l4" style="display:none"></div>
                @endif
            </div>
        </div>
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
    </div>
</div>
</section>

@include('footer')

<div id="modalExcluir" class="modal">
    <form action="" id="excluir" method="DELETE">
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
    <form action="" id="excluirComentario" method="DELETE">
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

        </div>
        <div class="modal-footer">
            <div>
                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Denunciar</a>
            </div>
            <div><a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a></div>
        </div>
    </div>
</div>
@stop
