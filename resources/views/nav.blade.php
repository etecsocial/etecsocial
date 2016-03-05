<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

<!-- MODAL ADD EVENTO -->
<div id="novoevento" class="modal">
    <form method="POST" id="addevento" action="{{ url('ajax/agenda') }}">
        <div class="modal-content">
            <h4>Adicionar Evento</h4>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="title" type="text" required>
                    <label for="title">Título</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="description" type="text">
                    <label for="title">Descrição (opcional)</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input name="start" type="date">
                    <label for="inicio" class="active" id="inicio">Data</label>
                </div>
                <div id="fim" class="input-field col s6" style="display:none">
                    <input name="end" type="date">
                    <label for="fim" class="active">Fim</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="tipo" value="0" id="test11" type="radio" checked>
                    <label for="test11">Um dia</label>
                    <input name="tipo" value="1" id="test21"  type="radio">
                    <label for="test21">Mais de um dia</label>
                </div>   
                <div class="input-field col s12 l6">
                    <input name="publico" value="0" id="test12" type="radio" checked>
                    <label for="test12">Pessoal</label>
                    <input name="publico" value="1" id="test22"  type="radio">
                    <label for="test22">Compartilhado</label>
                </div>
            </div>
            <div class="row">
                @if(Auth::user()->tipo == 2)
                <div class="addturma input-field col s6" style="display:none">
                    <select name="modulo" id="modulo" type="text">
                        @foreach(App\Modulo::get() as $modulo)
                        <option value="{{ $modulo->id }}">{{ $modulo->modulo }}º</option>
                        @endforeach
                    </select>
                </div>
                <div class="addturma input-field col s6" style="display:none">
                    <select name="turma" id="turma" type="text">
                        @foreach(App\User::turmas() as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
                        @endforeach
                    </select>     

                </div>
                @else 
                <div class="addturma input-field col s12" style="display:none"><p>Você irá compartilhar esse evento com a sua sala.</p></div>
                @endif
            </div>
        </div>
        <div class="modal-footer color-sec">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Add</button>
        </div>
    </form>
</div>
<!-- MODAL ADD EVENTO -->

<!-- MODAL VER POST -->
<div id="verpost" class="modal modal-fixed-footer">
    <div class="modal-content" id="modalpost"></div>
    <div class="modal-footer color-sec">
        <a style="cursor:pointer" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Fechar</a>
    </div>
</div>

<div id="modalConta" class="modal modal-fixed-footer" style="background-color: #f4f4f4">
    <form id="conta" method="POST" action="{{ url('/ajax/config') }}">
        <div class="modal-content">

            <h6>Configurações da Conta</h6>

            <li class="divider"></li>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs" style="background: transparent">
                        <li class="tab col s6"><a href="#infos-pessoais" class="active black-text">Básico</a></li>
                        <li class="tab col s6"><a href="#infos-seguranca" class="black-text">Segurança</a></li>
                    </ul>
                </div>
                <div id="infos-pessoais" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">

                            <div class="file-field input-field">
                                <div class="btn color-sec">
                                    <span>Foto</span>
                                    <input name="foto" type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>

                        </div>  

                        <div class="input-field col s12 l6">
                            <input value="{{ Auth::user()->nome }}" name="nome" placeholder="Nome completo" class="validate" type="text" name="nome" id="nome">
                            <label for="nome" class="active">Nome e sobrenome</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="username" name="username" value="{{ Auth::user()->username }}" placeholder="Nome de usuario" class="validate" id="username">
                            <label for="username" class="active">Nome de usuário</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="date" name="nasc" name="nasc" id="nasc" value="{{ Auth::user()->nasc ? Auth::user()->nasc : "" }}"  placeholder="Data de Nascimento" class="validate">
                            <label for="nasc" class="active">Data de nascimento</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="habilidades" name="habilidades" id="habilidades" value="{{ Auth::user()->habilidades ? Auth::user()->habilidades : "" }}" placeholder="Suas habilidades" class="validate">
                            <label for="habilidades" class="active">Habilidades</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="text" value="{{ Auth::user()->empresa ? Auth::user()->empresa : "" }}" placeholder="Empresa" class="validate">
                            <label for="empresa" class="active">Empresa</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="instituicao" value="{{ App\User::myInfoAcademica()->instituicao }}" placeholder="Instituicao" class="validate" disabled>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="text" name="cidade" value="{{ Auth::user()->cidade ? Auth::user()->cidade : "" }}" placeholder="Cidade"  class="validate">
                            <label for="cidade" class="active">Cidade</label>
                        </div>
                    </div>
                    @if(Auth::user()->tipo == 1)
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="modulo" value="{{ App\User::myInfoAcademica()->modulo }}" placeholder="Módulo" class="validate" disabled>
                            <label for="modulo" class="active">Módulo</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="text" name="curso" value="{{ App\User::myInfoAcademica()->curso }}" placeholder="Curso" class="validate" disabled>
                            <label for="curso" class="active">Curso</label>
                        </div>
                    </div>
                    @endif
                </div>
                <div id="infos-seguranca" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" name="email" value="{{ Auth::user()->email }}" placeholder="@etec.sp.gov.br" class="validate" disabled>
                            <label for="email" class="active">E-mail institucional</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="email_alternativo" value="{{ Auth::user()->email_alternativo }}" placeholder="E-mail" class="validate">
                            <label for="email_alternativo" class="active">E-mail alternativo</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s4">
                            <input type="password" name="senha" placeholder="Nova senha" class="validate">
                            <label for="senha" class="active">Nova senha</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="password" name="senha_confimation" placeholder="Repita a nova senha" class="validate">
                            <label for="senha" class="active">Confirmar nova senha</label>
                        </div>

                        <div class="input-field col s4">
                            <input type="password" name="senha_atual" placeholder="Senha atual" class="validate">
                            <label for="senha" class="active">Senha atual</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer color-sec-darken">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </form>
</div>
<header id="header" class="page-topbar">
    <div class="navbar-fixed">
        <nav class="red darken-1">
            <div class="nav-wrapper">
                <div class="nav-wrapper container"><a id="logo-container" href="{{ url('/') }}" class="brand-logo">ETEC Social</a>
                    <ul class="right icons-side">
                        <li class="hide-on-med-and-down">
                            <a href="#tarefas" id="tasks" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-people"><span class="badge amc white-text">{{ App\Amizade::count() }}</span></i></a>
                        </li>
                        <li>
                            <a href="#notificacoes" onclick="newnoti()" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-social-notifications"><span class="badge noti white-text">{{ App\Notificacao::count() }}</span></i></a>
                        </li>
                        <li class="hide-on-med-and-down">
                            <a href="#chat" class="waves-effect waves-block waves-light chat-toggle"><i class="mdi-communication-forum"><span class="badge noti white-text">{{ App\Chat::count() }}</span></i></a>
                        </li>
                    </ul>

                    <div class="header-search-wrapper hide-on-med-and-down" style="margin-top:10px">
                        <i class="mdi-action-search" style="top: 5px;left: 15px;"></i>
                        
                        <input autocomplete="off" style="padding-left: 55px;width: 89%" type="text" name="Search" onkeyup="buscar(this.value)" id="search-input" class="header-search-input z-depth-2" placeholder="Procure por amigos, professores, postagens ou grupos" />
                    </div>
                    <style>
                    @media only screen and (min-width:992px) {
                        #results-search {
                            padding-left: 240px;
                            margin-top: -13px;
                        }
                    }
                    </style>
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
            <ul id="slide-out" class="side-nav fixed leftside-navigation collapsible" data-collapsible="accordion" >
                <li class="user-details cyan darken-2">
                    <div class="row">
                        <div class="col col s4 m4 l4">
                            <a href="{{ App\User::myAvatar() }}" data-lightbox="{{ Auth::user()->username }}" style="margin-bottom: 10px;padding-left: 0;width: 80px">
                                <img src="{{ App\User::myAvatar() }}" alt="" class="circle responsive-img valign profile-image">
                            </a>
                        </div>
                        <div class="col col s8 m8 l8">
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="{{ url(Auth::user()->username) }}"><i class="mdi-action-face-unlock"></i> Perfil</a>
                                </li>
                                <li><a href="#modalConta" class="wino"><i class="mdi-action-settings"></i> Conta</a>
                                </li>
                                <li><a href="#"><i class="mdi-communication-live-help"></i> Ajuda</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="{{ url('/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Sair</a>
                                </li>
                            </ul>
                            <a class="btn-flat dropdown-button waves-effect white-text profile-btn" href="#" data-activates="profile-dropdown">{{ Auth::user()->nome }}<i class="mdi-navigation-arrow-drop-down right"></i></a>
                            <p class="user-roal">
                                @if(Auth::user()->tipo == 1)
                                Aluno
                                @elseif(Auth::user()->tipo == 2) 
                                Professor
                                @else
                                Moderador
                                @endif
                            </p>
                        </div>
                    </div>
                </li>
                <li class="bold active"><a href="{{ url('/') }}" class="waves-effect waves-cyan"><i class="mdi-action-dashboard color-sec-darken-text"></i> Página Inicial</a>
                </li>
                <li class="bold">
                    <a href="{{ url('/mensagens') }}" class="waves-effect waves-cyan"><i class="mdi-content-mail color-sec-darken-text"></i> Mensagens 
                        @if (App\Chat::count() > 0)
                        <span class="new badge">{{ App\Chat::count() }}</span>
                        @endif
                    </a> 
                </li>
                <li class="bold">
                    <a href="{{ url('/grupos') }}" class="waves-effect waves-cyan"><i class="fa fa-book color-sec-darken-text"></i> Grupos</a>
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
                <li class="bold"><a href="{{ url('/desafios') }}" class="waves-effect waves-cyan"><i class="mdi-action-account-balance color-sec-darken-text"></i> Desafios <span class="new badge">1</span></a></li>
                <li class="bold"><a class="waves-effect waves-cyan collapsible-header"><i class="mdi-action-assessment color-sec-darken-text"></i> Ranking</a>
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
                    <a href="#" class="chat-back right"><i class="mdi-navigation-close"></i></a>
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
                            @if(!App\Amizade::carrega())
                            <p>Não há novas solicitações de amizade.</p>
                            @else
                            <ul class="collection transparent" id="solic">
                                @foreach(App\Amizade::carrega() as $ami)
                                <li class="ami-{{ $ami->id_user1 }} collection-item avatar transparent">
                                    <img src="{{ App\User::avatar($ami->id_user1) }}" alt="" class="circle">
                                    <span class="title">{{ App\User::verUser($ami->id_user1)->nome }}</span>
                                    <small>
                                        <p>Quer ser sua amigo</p>
                                        <a onclick="add({{ $ami->id_user1 }})" style="cursor:pointer"><span class="left-align">Aceitar</span></a>
                                        <a onclick="recusar({{ $ami->id_user1 }})" style="cursor:pointer"><span class="right-align right">Recusar</span></a>
                                    </small>
                                    <a href="#!" class="secondary-content"><i class="mdi-social-person-add"></i></a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <div id="notificacoes" class="col s12" style="display: block;">
                            <p><span class="left-align">Notificações</span>
                                <span class="right-align right"><small><a style="cursor:pointer" onclick="read()">Marcar como lido</a></small></span></p>
                            @if(!App\Notificacao::carrega())
                            <p>Não há novas notificações.</p>
                            @else
                            <ul class="collection transparent" id="abnot">
                                @foreach(App\Notificacao::carrega() as $not)
                                @if($not->is_post)
                                <li onclick="abrirPost({{ $not->action }})" class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
                                    <img src="{{ App\User::avatar($not->id_rem) }}" alt="" class="circle">
                                    <span class="title">{{ App\User::verUser($not->id_rem)->nome }}</span>
                                    <small>
                                        <small>
                                            <p>{{ $not->texto }}</p>
                                            <i>{{ Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</i>
                                            @if(!$not->visto)
                                            <span class="new badge"></span>
                                            @endif
                                        </small>
                                    </small>
                                </li>
                                @else
                                <li class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
                                    <img src="{{ App\User::avatar($not->id_rem) }}" alt="" class="circle">
                                    <span class="title">{{ App\User::verUser($not->id_rem)->nome }}</span>
                                    <small>
                                        <small>
                                            <p>{{ $not->texto }}</p>
                                            <i>{{ Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</i>
                                            @if(!$not->visto)
                                            <span class="new badge"></span>
                                            @endif
                                        </small>
                                    </small>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <div id="chat" class="col s12">
                            <div class="contacts">
                                <div class="nano">

                                </div>
                            </div>
                            <div class="messages">
                                <div class="topbar">
                                    <a style="cursor:pointer" class="chat-toggle"><i class="mdi-navigation-close"></i></a>
                                    <a style="cursor:pointer" class="chat-back"><i class="mdi-hardware-keyboard-arrow-left"></i>Voltar</a>
                                </div>
                                <div id="chat">
                                    <div class="list">
                                        <div class="nano scroll-bottom">
                                            <div class="nano-content" id="msgs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="send">
                                    <form >
                                        <div class="input-field">
                                            <input type="hidden" id="id-chat" value="0">
                                            <input autocomplete="off" id="chat-message" type="text" id="chat-message" name="chat-message">
                                        </div>
                                        <button onclick="enviarMsg()" class="btn waves-effect z-depth-0 cyan"><i class="mdi-content-send"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
            <li class="tooltipped" data-tooltip="Meu Perfil" data-position="left" data-delay="50"><a href="{{ url(Auth::user()->username) }}" class="btn-floating blue"><i class="large mdi-social-mood"></i></a></li>
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
