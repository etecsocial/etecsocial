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
                    <a id="logo-container" href="{{ url('/') }}" class="brand-logo"><img src="{{ url('images/logo-b.png') }}"></a>
                    <ul class="right icons-side">
                        <li class="hide-on-med-and-down">
                            <a href="#tarefas" id="tasks" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-people"><span class="badge amc white-text">{{ App\Amizade::count() }}</span></i></a>
                        </li>
                        <li>
                            <a href="#notificacoes" onclick="newnoti()" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-notifications"><span class="badge noti white-text" id="num_not">{{ App\Notificacao::count() }}</span></i></a>
                        </li>
                        <li class="hide-on-med-and-down">
                            <a href="#chat" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-communication-forum"><span class="badge noti white-text" id="num_chat">{{ App\Chat::count() }}</span></i></a>
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
                                @if(auth()->user()->type == 1) Aluno @elseif(auth()->user()->type == 2) Professor @else Moderador @endif
                            </p>
                        </div>
                    </div>
                </li>
                <li class="bold active"><a href="{{ url('/') }}" class="waves-effect waves-cyan"><i class="mdi-action-dashboard color-sec-darken-text"></i> Página Inicial</a>
                </li>
                <li class="bold">
                    <a href="{{ url('/mensagens') }}" class="waves-effect waves-cyan"><i class="mdi-content-mail color-sec-darken-text"></i> Mensagens 
                        @if($msgsUnread)
                        <span class="new badge">{{ $msgsUnread }}</span>
                        @endif
                    </a>
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
                <li>
                    <div class="divider"></div>
                </li>
                <li class="bold"><a href="{{ url('/agenda') }}" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation color-sec-darken-text"></i> Agenda</a>
                    <li class="bold"><a href="{{ url('/tarefas') }}" class="waves-effect waves-cyan"><i class="mdi-content-content-paste color-sec-darken-text"></i> Tarefas</a>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li class="bold"><a href="{{ url('/desafios') }}" class="waves-effect waves-cyan"><i class="mdi-social-whatshot color-sec-darken-text"></i> Desafios </a></li>
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
            <a href="#" data-activates="slide-out" style="z-index:1000" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only red darken-3"><i class="mdi-navigation-menu"></i></a>
        </aside>
        <div class="chat">
            <div class="layer-overlay"></div>
            <div class="layer-content">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs transparent" style="width: 100%;">
                            <li class="tab col s3" style="width: 25%;"><a id="tabTasks" class="white-text" href="#tarefas"><i style="margin-top:12px" class="mdi-social-people"><span class="badge amc">{{ App\Amizade::count() }}</span></i></a>
                            </li>
                            <li class="tab col s3" style="width: 25%;"><a onclick="newnoti()" id="tabNot" href="#notificacoes" class="white-text"><i style="margin-top:12px" class="mdi-social-notifications"><span data-num="{{ App\Notificacao::count() }}" id="num" class="badge noti">{{ App\Notificacao::count() }}</span></i></a>
                            </li>
                            <li class="tab col s3" style="width: 25%;"><a id="tabChat" href="#chat" class="white-text"><i style="margin-top:12px" class="mdi-communication-forum"><span class="badge">{{ App\Chat::count() }}</span></i></a>
                            </li>
                        </ul>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                        <div class="indicator" style="right: 598px; left: 0px;"></div>
                    </div>
                    <div class="col s12 m12 14 transparent white-text">
                        <div id="tarefas" class="col s12 white-text" style="display: block;">
                            <p>Solicitações de Amizade</p>
                            <ul class="collection transparent" id="solic">
                                @if(!App\Amizade::carrega())
                                <li class="collection-item transparent">
                                    <i class="mdi-action-info-outline tiny"></i>
                                    <small>Não há novas solicitações.</small>
                                </li>
                                @else @foreach(App\Amizade::carrega() as $amigo)
                                <li class="ami-{{ $amigo->id_user1 }} collection-item avatar transparent">
                                    <img src="{{ auth()->user()->avatar($amigo->id_user1) }}" alt="" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($amigo->id_user1)->nome }}</span>
                                    <small>
                                        <p>Quer ser sua amigo</p>
                                        <a onclick="add({{ $amigo->id_user1 }})" style="cursor:pointer"><span class="left-align">Aceitar</span></a>
                                        <a onclick="recusar({{ $amigo->id_user1 }})" style="cursor:pointer"><span class="right-align right">Recusar</span></a>
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
                                    <img src="{{ auth()->user()->avatar($not->id_rem) }}" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($not->id_rem)->nome }}</span>
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
                                    <img src="{{ auth()->user()->avatar($not->id_rem) }}" class="circle">
                                    <span class="title">{{ auth()->user()->verUser($not->id_rem)->nome }}</span>
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
                        <div id="chat" class="col s12" style="display: block;">
                            <!-- Contacts -->
                            <div class="contacts" style="margin-top: 30px;">
                                <div class="nano scroll-bottom">
                                    <div class="nano-content">
                                        <span class="label">Online</span>
                                        
                                        <div class="user" onclick="javascript:abrirChat(2)">
                                            <img src="images/default-user.png" alt="Felecia Castro" class="circle photo">
                                            <div class="name">Felecia Castro</div>
                                            <div class="status">Lorem status</div>
                                            <div class="online"><i class="green-text fa fa-circle"></i>
                                            </div>
                                        </div>                  
                                               
                                        <span class="label">Offline</span>
                                        
                                        <div class="user" onclick="javascript:abrirChat(1)">
                                            <img src="images/default-user.png" alt="Felecia Castro" class="circle photo">
                                            <div class="name">Felecia Castro</div>
                                            <div class="status">Lorem status</div>
                                            
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- /Contacts -->
                            <!-- Messages -->
                            <div class="messages">
                                <!-- Top Bar with back link -->
                                <div class="topbar">
                                    <a href="#!" class="chat-toggle" style="margin-top:12px"><i class="mdi-navigation-close"></i></a>
                                    <a href="#!" class="chat-back" onclick="javacript:fecharChat()"><i class="mdi-hardware-keyboard-arrow-left"></i>Voltar</a>
                                </div>
                                <!-- /Top Bar with back link -->
                                <!-- All messages list -->
                                <div class="list">
                                    <div class="nano scroll-bottom">

                                        <div class="nano-content" id="msgs" class="messages-chat">
                                            <br>
                                            <center><img src="images/loading.gif"></center>
                                        </div>
                                    
                                </div>
                                </div>
                                <!-- /All messages list -->
                                <!-- Send message -->
                                <div class="send">
                                    <form action="#!">
                                        <input id="id-chat" type="hidden" value="">
                                        <div class="input-field">
                                            <input id="chat-message" type="text" name="chat-message">
                                        </div>
                                        <button class="btn waves-effect z-depth-0 cyan" onclick="enviarMsg()"><i class="mdi-content-send"></i>
                                        </button>
                                    </form>
                                </div>
                                <!-- /Send message -->
                            </div>
                            <!-- /Messages -->
                        </div>
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
            <li class="tooltipped" data-tooltip="Minhas tarefas" data-position="left" data-delay="50"><a href="{{ url('/tarefas') }}" class="btn-floating red"><i class="large mdi-action-done-all"></i></a></li>
            <li class="tooltipped" data-tooltip="Novo desafio" data-position="left" data-delay="50"><a href="#!" onclick="javascript:Materialize.toast('<span>Recurso não disponível ainda.</span>', 3000);" class="btn-floating yellow darken-1"><i class="large mdi-social-whatshot"></i></a></li>
        </ul>
    </div>
    <section id="content">
        <div class="header-search-wrapper blue lighten-1 hide-on-large-only">
            <i class="mdi-action-search active"></i>
            <input type="text" name="Search" onkeyup="buscar(this.value)" id="search-input" class="header-search-input z-depth-2" placeholder="Procure por alunos, grupos, prof..." />
        </div>
