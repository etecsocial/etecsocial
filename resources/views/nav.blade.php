@if ( ! session()->has('loading_screen'))
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
{{ session()->put('loading_screen', 'true') }} @endif
<style>
@media only screen and (min-width:992px) {
    #results-search {
        padding-left: 240px;
        margin-top: -13px;
    }
}
</style>
@include('modals')
<header id="header" class="page-topbar">
    <div class="navbar-fixed">
        <nav class="red darken-1">
            <div class="nav-wrapper">
                <div class="nav-wrapper container">
                    <a id="logo-container" href="{{ url('/') }}" class="brand-logo"><img src="{{ url('images/logo.png') }}"></a>
                    <ul class="right icons-side">
                        <li class="hide-on-med-and-down">
                            <a href="#chat" id="tasks" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-people"><span class="badge amc white-text">{{ App\Amizade::count() }}</span></i></a>
                        </li>
                        <li>
                            <a href="#notificacoes" onclick="newnoti()" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-notifications"><span class="badge noti white-text" id="num_not">{{ App\Notificacao::count() }}</span></i></a>
                        </li>
                        <li class="hide-on-med-and-down">
                            <a href="#tarefas" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-action-done-all"><span class="badge noti white-text" id="num_chat">{{ App\Chat::count() }}</span></i></a>
                        </li>
                    </ul>
                    <div class="header-search-wrapper hide-on-med-and-down" style="margin-top:10px">
                        <i class="mdi-action-search" style="top: 5px;left: 15px;"></i>
                        <input autocomplete="off" style="padding-left: 55px;width: 89%" type="text" name="Search" onkeyup="buscar(this.value)" id="search-input" class="header-search-input z-depth-2" placeholder="Procure por amigos, professores, postagens ou grupos" />
                    </div>
                    <div id="results-search" style="display: none; ">
                        <ul class="busca collection" style="width: 670px; background: #fff"></ul>
                    </div>
                </div>
        </nav>
        </div>
    </div>
</header>
<div id="main">
    <div class="wrapper">
        <aside id="left-sidebar-nav">
            <ul id="slide-out" class="side-nav fixed leftside-navigation collapsible" data-collapsible="accordion">
                <li class="user-details cyan darken-2">
                    <div class="row">
                        <div class="col col s4 m4 l4">
                            <a href="{{ auth()->user()->myAvatar() }}" data-lightbox="{{auth()->user()->username }}" style="margin-bottom: 10px;padding-left: 0;width: 80px">
                                <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image">
                            </a>
                        </div>
                        <div class="col col s8 m8 l8">
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="{{ url(auth()->user()->username) }}"><i class="mdi-action-face-unlock"></i> Perfil</a>
                                </li>
                                <li><a href="#modalConta" class="wino"><i class="mdi-action-settings"></i> Conta</a>
                                </li>
                                <li><a href="#modalAjuda" class="wino"><i class="mdi-communication-live-help"></i> Ajuda</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="{{ url('/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Sair</a>
                                </li>
                            </ul>
                            <a class="btn-flat dropdown-button waves-effect white-text profile-btn" href="#" data-activates="profile-dropdown">{{auth()->user()->name }}<i class="mdi-navigation-arrow-drop-down right"></i></a>
                            <p class="user-roal">
                                @if(auth()->user()->type == 1) Aluno @elseif(auth()->user()->type == 2) Professor @else Coordenador @endif
                            </p>
                        </div>
                    </div>
                </li>
                <li class="bold {!! active_class_path(['/']) !!}"><a href="{{ url('/') }}" class="waves-effect waves-cyan"><i class="mdi-action-dashboard color-sec-darken-text"></i> Página Inicial</a>
                </li>
                
                <li class="bold">
                    @if(isset($grupos[0]))
                    <a class="waves-effect waves-cyan collapsible-header">
                        <i class="mdi-social-group color-sec-darken-text"></i> Grupos
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            @foreach($grupos as $grupo)
                            <li><a href="{{ url('grupo/'.$grupo->url) }}">{{ $grupo->nome }}</a></li>
                            @endforeach
                            <li><a href="{{ url('grupos') }}">Ver todos</a></li>
                        </ul>
                    </div>
                    @else
                    <a class="waves-effect waves-cyan" href="{{ url('/grupos') }}">
                        <i class="mdi-social-group color-sec-darken-text"></i> Grupos
                    </a>
                    @endif
                </li>
                <li class="bold {!! active_class_path(['mensagens']) !!}">
                    <a href="{{ url('/mensagens') }}" class="waves-effect waves-cyan"><i class="mdi-content-mail color-sec-darken-text"></i> Mensagens 
                        @if($msgsUnread)
                        <span class="new badge">{{ $msgsUnread }}</span>
                        @endif
                    </a>
                </li>
                <li class="bold {!! active_class_path(['agenda']) !!}"><a href="{{ url('/agenda') }}" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation color-sec-darken-text"></i> Agenda de estudos</a>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li class="bold {!! active_class_path(['desafios']) !!}"><a href="{{ url('/desafios') }}" class="waves-effect waves-cyan"><i class="mdi-social-whatshot color-sec-darken-text"></i> Desafios </a></li>
                    <li class="bold"><a class="waves-effect waves-cyan collapsible-header"><i class="mdi-action-trending-up color-sec-darken-text"></i> Ranking</a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ url('/ranking') }}">Geral</a>
                                </li>
                                <li>
                                    <a href="{{ url('/ranking/etec') }}">Por ETEC</a>
                                </li>
                                <li>
                                    <a href="{{ url('/ranking/turma') }}">Por Turma</a>
                                </li>
                            </ul>
                        </div>
                    </li>
            </ul>
             </div>
            <a href="#" data-activates="slide-out" style="z-index:1000" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only red darken-3"><i class="mdi-navigation-menu"></i></a>
        </aside>
        <div class="chat">
            <div class="layer-overlay"></div>
            <div class="layer-content">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs transparent" style="width: 100%;">
                            <li class="tab col s3" style="width: 25%;"><a id="tabTasks" class="white-text" href="#chat"><i style="margin-top:12px" class="mdi-social-people"><span class="badge amc">{{ App\Amizade::count() }}</span></i></a>
                            </li>
                            <li class="tab col s3" style="width: 25%;"><a onclick="newnoti()" id="tabNot" href="#notificacoes" class="white-text"><i style="margin-top:12px" class="mdi-social-notifications"><span data-num="{{ App\Notificacao::count() }}" id="num" class="badge noti">{{ App\Notificacao::count() }}</span></i></a>
                            </li>
                            <li class="tab col s3" style="width: 25%;"><a id="tabChat" href="#tarefas" class="white-text"><i style="margin-top:12px" class="mdi-action-done-all"><span class="badge">{{ App\Chat::count() }}</span></i></a>
                            </li>
                        </ul>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                    </div>
                    <div class="col s12 m12 14 transparent white-text">
                        <div id="chat" class="col s12 white-text" style="display: block;">
                            <p>Solicitações de Amizade</p>
                            <ul class="collection transparent" id="solic">
                                @if(!App\Amizade::carrega())
                                <li class="collection-item transparent">
                                    <i class="mdi-action-info-outline tiny"></i>
                                    <small>Não há novas solicitações.</small>
                                </li>
                                @else @foreach(App\Amizade::carrega() as $amigo)
                                <li class="ami-{{ $amigo->user_id1 }} collection-item avatar transparent">
                                    <img src="{{ auth()->user()->avatar($amigo->user_id1) }}" alt="" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($amigo->user_id1)->nome }}</span>
                                    <small>
                                        <p>Quer ser sua amigo</p>
                                        <a onclick="add({{ $amigo->user_id1 }})" style="cursor:pointer"><span class="left-align">Aceitar</span></a>
                                        <a onclick="recusar({{ $amigo->user_id1 }})" style="cursor:pointer"><span class="right-align right">Recusar</span></a>
                                    </small>
                                    <a href="#!" class="secondary-content"><i class="mdi-social-person-add"></i></a>
                                </li>
                                @endforeach @endif
                            </ul>
                        </div>
                        <div id="notificacoes" class="col s12" style="display: block;">
                            <p>Notificações <span class="right-align right"><small><a style="cursor:pointer" onclick="read()">Marcar como lido</a></small></span></p>
                            <ul class="collection transparent">
                                @if(!$notificacoes = App\Notificacao::carrega())
                                <li class="collection-item transparent">
                                    <i class="mdi-action-info-outline tiny"></i>
                                    <small>Não há novas notificações.</small>
                                </li>
                                @else @foreach($notificacoes as $not) @if($not->is_post)
                                <li onclick="abrirPost({{ $not->action }})" class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
                                    <img src="{{ auth()->user()->avatar($not->rem_id) }}" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($not->rem_id)->nome }}</span>
                                    <small>
                                        <p>{{ $not->texto }}</p>
                                        <span class="right-align">{{ Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</span>
                                        <span class="right-align right">
                                            @if(!$not->visto)
                                            <span class="new badge"></span>
                                            @endif
                                        </span>
                                    </small>
                                    
                                </li>
                                @else
                                <li class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
                                    <img src="{{ auth()->user()->avatar($not->rem_id) }}" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($not->rem_id)->nome }}</span>
                                    <small>
                                        <p>{{ $not->texto }}</p>
                                        <span class="right-align">{{ Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</span>
                                        @if(!$not->visto)
                                        <span class="new badge"></span>
                                        @endif
                                    </small>
                                    <a href="#!" class="secondary-content"></a>
                                </li>
                                @endif @endforeach @endif
                            </ul>
                        </div>
                        
                    <div id="tarefas" class="col s12 white-text" style="display: block;">
                        <p>Suas tarefas</p>
                        <div class="col s12 m12 transparent white-text">
                            <ul id="task-card" class="collection white-text" style="margin-left: -10px">

                                
                                 @foreach(\App\Tarefa::carrega() as $task)
                            <li class="tarefa collection-item dismissable none-bg" data-id="{{ $task->id }}" data-date="{{ $task->data }}">
                                @if($task->checked)
                                <input type="checkbox" id="{{ $task->id }}" checked="checked" onclick="javascript:checkTask('{{ $task->id }}')"> @else
                                <input type="checkbox" id="{{ $task->id }}" onclick="javascript:checkTask('{{ $task->id }}')"> @endif
                                <label for="{{ $task->id }}" class="white-text">{{ $task->desc }}<a class="secondary-content"><span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span></a>
                                </label>
                                @if($task->data > time() + 3*24*60*60)
                                <span class="task-cat green darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @elseif($task->data > time())
                                <span class="task-cat yellow darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @else
                                <span class="task-cat red darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span> @endif
                            </li>
                            @endforeach
                            
                             
                                
                            </ul>
                        </div>
                        <a class="btn-flat waves-effect blue accent-2 white-text"><i class="mdi-editor-mode-edit right"></i>Adicionar tarefa</a>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div id="btn-fixed" class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large color-sec-darken">
            <i class="large mdi-navigation-apps"></i>
        </a>
        <ul>
            <li class="tooltipped" data-tooltip="Meu Perfil" data-position="left" data-delay="50"><a href="{{ url(auth()->user()->username) }}" class="btn-floating blue"><i class="large mdi-social-mood"></i></a></li>
            <li class="tooltipped" data-tooltip="Novo Evento" data-position="left" data-delay="50"><a href="#novoevento" class="btn-floating green wino"><i class="large mdi-editor-insert-invitation"></i></a></li>
        </ul>
    </div>
    <section id="content">
        <div class="header-search-wrapper blue lighten-1 hide-on-large-only">
            <i class="mdi-action-search active"></i>
            <input type="text" name="Search" onkeyup="buscar(this.value)" id="search-input" class="header-search-input z-depth-2" placeholder="Procure por alunos, grupos, professor..." />
        </div>
