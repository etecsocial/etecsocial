@extends('base')
@section('title') Início | ETEC Social @stop

@section('style') 
{!! Minify::stylesheet([
'/css/font.css',
'/css/asset.css',
'/css/style.css', 
'/js/plugins/fullcalendar/css/fullcalendar.min.css',
])->withFullURL() !!} 
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
'/js/plugins/lightbox-plus-jquery.min.js',
'/materialize-css/js/materialize.min.js',
'/js/form.min.js',


'/js/plugins/jquery.nanoscroller.min.js',
'/js/plugins/sparkline/jquery.sparkline.min.js',
'/js/plugins/sparkline/sparkline-script.js',
'/js/plugins/succinct-master/jQuery.succinct.min.js',


'/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js',
'/js/plugins/fullcalendar/lib/moment.min.js',
'/js/plugins/fullcalendar/js/fullcalendar.min.js',
'/js/plugins/fullcalendar/fullcalendar-script.js',

'/js/script.js',
'/js/script-feed.js',
'/js/plugins.js'
])->withFullURL() !!}

@if(auth()->user()->first_login != 0)
<script>
    $(document).ready(function() {
    $("#modalFirst").openModal();
    });</script>
@endif @if($id)
<script>
    $("#verpost").openModal();
    abrirPost({{ $id }})
</script>
@endif @stop @section('content') @include('nav')

<div class="container" style="margin-top:20px">
    <div id="chart-dashboard">
        <div class="row">
            <div class="col s12 m12 l4">
                <ul id="task-card" class="collection with-header">
                    <li class="collection-header cyan">
                        <h4 class="task-card-title">Tarefas</h4>
                        <p class="task-card-date">{{ \Carbon\Carbon::now()->formatLocalized('%A %d %B %Y') }}</p>
                    </li>
                    @forelse($tasks as $task)
                    <li class="tarefa collection-item dismissable" data-idtask="{{ $task->id }}" data-date="{{ $task->data }}">
                        @if($task->checked)
                        <input type="checkbox" id="{{ $task->id }}-tab" checked="checked" onclick="javascript:checkTask('{{ $task->id }}')"> @else
                        <input type="checkbox" id="{{ $task->id }}-tab" onclick="javascript:checkTask('{{ $task->id }}')"> @endif
                        <label for="{{ $task->id }}-tab" class="truncate">{{ $task->desc }}
                            <a class="secondary-content">
                                <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span>
                            </a>
                        </label>
                        @if($task->data > time() + 3*24*60*60)
                        <span class="task-cat green darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> 
                        @elseif($task->data > time())
                        <span class="task-cat yellow darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> 
                        @else
                        <span class="task-cat red darken-1">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @endif
                    </li>
                    @empty
                    <li class="tarefa collection-item">
                        <p class="center-align">Você não possui nenhuma tarefa.</p>
                    </li>
                    @endforelse

                    <!--Colocar esse form em uma modal, fica feio assim.-->
                    <!--                    <li class="tarefa collection-item dismissable">
                                            Nova tarefa
                                            {!! Form::open(array('url' => '/task')) !!}        
                                            <div class="input-field col s12 m12 l12 tooltipped" data-tooltip="Até quando sua tarefa deve ser concluída?" data-position="right" data-delay="1000">
                                                <input id="cc" type="date"  pattern="^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$" required name="date" class="datepicker validate">
                                                <label for="date" data-error="Data inválida" data-success="Tudo bem. Lembraremos você!" style="width: 350px" class="left-align">Selecione a data</label>
                                            </div>
                    
                                            <div class="input-field col s12 m12 l12 tooltipped" data-tooltip="Informe seu email pessoal" data-position="right" data-delay="1000">
                                                <input type="text" lenght="50" required name="desc" placeholder="O que você tem que fazer, {{ explode(' ',auth()->user()->name)[0] }}?" class="validate">
                                                <label for="desc" data-error="Sua descrição parece ser muito curta." style="width: 350px" class="left-align">Tarefa</label>
                                            </div>
                                            {!! Form::close() !!}
                                        </li>-->
                </ul>
            </div>
            <div id="profile-page-wall-share" class="col s12 m12 l8" style="margin: 10px 0px 36px 0">
                <div class="col s12">
                    <ul class="tabs tab-profile cyan">
                        <li class="tab col s4"><a class="white-text waves-light">Publicar conteúdo</a></li>
                    </ul>
                    {!! Form::open(array('url' => '/ajax/post', 'id' => 'publicar')) !!}         
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
                            <label for="publicacao">O que há de novo para compartilhar com seus amigos?</label>
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
                        <div class="col s2 l4" style="margin-bottom:10px">
{!! Form::submit('Publicar', ['class' => 'btn red right-align']) !!}                        </div>
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
                    {!! Form::close() !!}
                    <div id="modalAjuda" class="modal">
                        <div class="modal-content">
                            <h4>Ajuda</h4>
                            <p>Caso queira perguntar algo, adicione a Tag "ajuda". Para links, utilize a "link". </p>
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
                    @if(isset(auth()->user()->status))
                    <div id="us">
                        <p class="left" style="margin-top:15px">{{{ auth()->user()->status }}}</p>
                    </div>
                    @else
                    <i class="left activator" style="margin-top:15px">Adicione um novo status. Clique aqui.</i> @endif
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Atualizar Status <i class="mdi-navigation-close right"></i></span>
                    <p class="grey-text">Há algo novo para compartilhar com seus amigos, {{ auth()->user()->name }}?</p>
                    <div class="input-field col s12 accent-4">
                        <form method="POST" action="{{ url('ajax/status') }}" id="status">
                            <input id="status" name="status" type="text" class="validate" style="color:black">
                            <label for="status">Novo Status</label>
                            <button type="submit" style="font-size:14px" class="card-title waves-effect waves-light btn red">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s6 m6 l6">
                <div class="card">
                    <div class="card-content blue white-text center">
                        <p class="card-stats-title"><i class="mdi-social-group-add hide-on-med-and-down"></i> Pontuação</p>
                        <h4 class="card-stats-number" id="pontuacao">{{ \App\Pontuacao::total() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col s6 m6 l6">
                <div class="card">
                    <div class="card-content purple white-text center">
                        <p class="card-stats-title"><i class="mdi-editor-attach-money hide-on-med-and-down"></i>Desafios</p>
                        <h4 class="card-stats-number">@if( isset(auth()->user()->num_desafios) ) {{ auth()->user()->num_desafios }} @else 0 @endif</h4>
                    </div>
                </div>
            </div>
            <div class="col s6 m6 l6">
                <div class="card">
                    <div class="card-content orange white-text center">
                        <p class="card-stats-title"><i class="mdi-action-trending-up hide-on-med-and-down"></i> Auxílios</p>
                        <h4 class="card-stats-number">@if( isset(auth()->user()->num_auxilios) ) {{ auth()->user()->num_auxilios }} @else 0 @endif</h4>
                    </div>
                </div>
            </div>
            <div class="col s6 m6 l6">
                <div class="card">
                    <div class="card-content green white-text center">
                        <p class="card-stats-title"><i class="mdi-action-trending-up hide-on-med-and-down"></i> Postagens</p>
                        <h4 class="card-stats-number" id="num-posts">{{ $countPosts }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l8">
            <ul class="tabs tab-profile cyan">
                <li class="tab col s4"><a class="white-text waves-light">Agenda de estudos</a></li>
            </ul>
            <div id="full-calendar">
                <div class="col s12 m6 l12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="card-widgets" class="seaction">
    <div class="row">
        <div class="col s12" id="post">
            @if(!isset($posts[0]))
            <div data-id="0" class="post blog col s12 m6 l4" style="display:none"></div>
            <ul class="collection with-header">
                <li class="collection-item center darken-4">Ainda não há publicações para serem exibidas por aqui! Publique algo ou adicione seus amigos.</li>
            </ul>
            @else @include('feed.posts') @endif
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
        <div class="col s12 m4 center"> </div>
    </div>
</div>
</section>
</div>






<div id="modalExcluir" class="modal">
    <form id="excluir" method="DELETE">
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
    <form id="excluirComentario" method="DELETE">
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
        <h4><strong>Denunciar Publição</strong></h4>
        <li class="divider"></li>
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
@include('footer')
@stop
