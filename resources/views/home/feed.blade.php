@extends('app')
@section('title')
ETEC Social | Home
@stop

@section('style')
{!! Html::style('css/font.css') !!}
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
{!! Html::style('js/plugins/fullcalendar/css/fullcalendar.min.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/form.min.js') !!}
{!! Html::script('js/jquery.tagsinput.min.js') !!}

{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/jquery.bxslider.min.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}

{!! Html::script('js/plugins/fullcalendar/lib/jquery-ui.custom.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/lib/moment.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/js/fullcalendar.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/fullcalendar-script.js') !!}

{!! Html::script('js/script.js') !!}
{!! Html::script('js/script-feed.js') !!}
{!! Html::script('js/plugins.js') !!}
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
                <div class="col s12 m12 l4">
                    <ul id="task-card" class="collection with-header">
                        <li class="collection-header cyan">
                            <h4 class="task-card-title">Minhas Tarefas </h4>
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
                            <label for="{{ $task->id }}">{{ $task->desc }}
                                <a class="secondary-content">
                                    <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span>
                                </a>
                            </label>
                            @if($task->data > time() + 3*24*60*60)
                                <span class="task-cat green darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                            @elseif($task->data > time())
                                <span class="task-cat yellow darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                            @else
                                <span class="task-cat red darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                            @endif
                        </li>
                        @endforeach
                        @else 
                        <li class="tarefa collection-item dismissable">
                            <p class="center-align">Você não ainda não criou nenhuma tarefa :(</p>
                        </li>
                        @endif
                    </ul>
                </div>

                <div id="profile-page-wall-share" class="col s12 m12 l8" style="margin: 10px 0px 36px 0">
                    <div class="col s12">
                        <ul class="tabs tab-profile cyan">
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
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l4">
                <div class="card red darken-1 white-text" style="min-height:200px">
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
                                <label for="status" >Novo Status</label>
                                <button type="submit" style="font-size:14px" class="card-title waves-effect waves-light btn red">Atualizar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col s6 m6 l6">
                    <div class="card">
                        <div class="card-content blue white-text center">
                            <p class="card-stats-title"><i class="mdi-social-group-add hide-on-med-and-down"></i> Reputação</p>
                            <h4 class="card-stats-number">{{ Auth::user()->reputacao }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col s6 m6 l6">
                    <div class="card">
                        <div class="card-content purple white-text center">
                            <p class="card-stats-title"><i class="mdi-editor-attach-money hide-on-med-and-down"></i>Desafios</p>
                            <h4 class="card-stats-number">{{ Auth::user()->num_desafios }}</h4>
                        </div>
                    </div>
                </div>                            
                <div class="col s6 m6 l6">
                    <div class="card">
                        <div class="card-content orange white-text center">
                            <p class="card-stats-title"><i class="mdi-action-trending-up hide-on-med-and-down"></i> Auxílios</p>
                            <h4 class="card-stats-number">{{ Auth::user()->num_auxilios }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col s6 m6 l6">
                    <div class="card">
                        <div class="card-content green white-text center">
                            <p class="card-stats-title"><i class="mdi-action-trending-up hide-on-med-and-down"></i> Postagens</p>
                            <h4 class="card-stats-number">{{ Auth::user()->num_auxilios }}</h4>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col s12 m12 l8" style="margin-bottom: 30px">
                <div id="calendar-widget"></div>
            </div>
            
        </div>
    </div>
    <div id="card-widgets" class="seaction">
        <div class="row">
            <div class="col s12" id="post">
                @include('home.posts')
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
