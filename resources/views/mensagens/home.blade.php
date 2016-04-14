@extends('app')

@section('title')
Mensagens | ETEC Social
@stop

@section('style')
{!! Html::style('css/font.css') !!}
{!! Html::style('css/materialize.css') !!}
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
{!! Html::style('css/mensagens/custom-style.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/firebase.js') !!}
{!! Html::script('js/form.min.js') !!}
{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}
{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}
{!! Html::script('js/script-mensagens.js') !!}
@stop

@section('content')

<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- START CONTENT -->
<section id="content">
    <!--start container-->
    <div class="container">
        <div id="mail-app" class="section">
            <div class="row">
                <div class="col s12">
                    <nav class="cyan">
                        <div class="nav-wrapper">
                            <div class="left col s12 m5 l5">
                                <ul>
                                    <li><a href="#!" class="email-menu"><i class="mdi-navigation-menu"></i></a>
                                    </li>
                                    <li><a class="email-type" id="title-msg-list">Mensagens recentes</a>
                                    </li>
                                    <li class="right"><a href="#!"><i class="mdi-action-search"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s12 m7 l7 hide-on-med-and-down">

                                <ul class="left">
                                    <li><a class="email-type" id="title-msg-details">Comunicados da coordenação</a></li>
                                </ul>
                                <ul class="right">
                                    <li class="active" id="icon-coord"><a><i class="mdi-content-content-paste tooltipped" data-tooltip='Comunicados da coordenação' data-position='bottom'></i></a></li>
                                    </li>
                                    <li onclick="delConversa()" id="del"><a><i class="mdi-action-delete tooltipped" data-tooltip='Apagar conversa' data-position='bottom'></i></a>
                                    </li>
                                    <li id="newMsg"><a><i class="mdi-content-add-circle-outline tooltipped" data-tooltip='Nova mensagem' data-position='bottom'></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col s12">
                    <div id="email-sidebar" class="col s2 m1 s1 card-panel" style="height: 200px !important">
                        <ul>
                            <li>
                                <img src="{{$myAvatar}}" alt="" class="circle responsive-img valign profile-image">
                            </li>
                            <li id="get-users-recents"><a><i class="get-users-recents icon-nav-list mdi-action-history tooltipped active" data-tooltip='Recentes' data-position='right'></i></a></li>
                            <li id="get-users-unread"><a><i class="get-users-unread icon-nav-list mdi-content-markunread tooltipped" data-tooltip='Não lidas' data-position='right'></i></a></li>
                            <li id="get-users-friends"><a><i class="get-users-friends icon-nav-list mdi-communication-contacts tooltipped" data-tooltip='Amigos' data-position='right'></i></a></li>
                            <li id="get-users-archives"><a><i class="get-users-archives icon-nav-list mdi-content-archive tooltipped" data-tooltip='Arquivadas' data-position='right'></i></a></li>
                            <li id="get-users-help" onclick="Materialize.toast('<span>Este recurso ainda está em desenvolvimento!</span>', 3000);"><a><i class="get-users-help icon-nav-list mdi-communication-live-help tooltipped" data-tooltip='Central de ajuda' data-position='right'></i></a></li>
                        </ul>
                    </div>
                    <div id="email-list" class="col s10 m4 l4 card-panel z-depth-1">
                        @include('mensagens.users')
                    </div>

                    <div id="email-details" class="col s12 m7 l7 card-panel">
                        <p class="email-subject truncate">Comunicado 01/coord.</p>
                        <hr class="grey-text text-lighten-2">
                        <div class="email-content-wrap">
                            <div class="email-content">
                                <b>Mogi mirim, 15 de março de 2016</b>
                                <p>Caros alunos</p>

                                <p>Informamos que bundle our framework with the latest iteration of Roboto Google has released. It comes with 5 different font weights you.</p>
                                <p>The latest iteration of Roboto Google has released. It comes use: 200, 300, 400, 500, 600.
                                    It comes with 5 different font weights you can use: 200, 300, 400, 500, 600.</p>
                                <p>Cordialmente,
                                <hr class="divider" style="width: 50%">
                                <p>André Luiz dos Santos<br>
                                    <span class="ultra-small">Diretor de Escola</span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal de criação de mensagem -->
            <div id="modal-nova-mensagem" class="modal">

                <div class="modal-content">
                    <nav class="red">
                        <div class="nav-wrapper">
                            <div class="left col s12 m5 l5">
                                <ul>
                                    <li><a href="#!" class="email-menu"><i class="modal-action modal-close  mdi-hardware-keyboard-backspace"></i></a>
                                    </li>
                                    <li><a href="#!" class="email-type">Nova mensagem</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s12 m7 l7 hide-on-med-and-down">
                                <ul class="right">
                                    <li class="tooltipped" data-tooltip="Anexar arquivo" data-position="bottom"><a href="#!"><i class="mdi-editor-attach-file"></i></a>
                                    </li>
                                    <li onclick="$('#nova-mensagem').submit()" style="cursor: pointer" class="tooltipped" data-tooltip="Enviar mensagem" data-position="bottom"><a><i class="modal-action mdi-content-send"></i>
                                        </a></li>
                                    <li style="cursor: pointer" class="tooltipped" data-tooltip="Fechar" data-position="bottom"><a href="#!"><i class="mdi-navigation-close"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </nav>
                </div>
                <div class="model-email-content">
                    <form class="col s12" id="nova-mensagem" type="post">
                        <div class="row">
                            <input type="hidden" name="id_dest" id="id_dest">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="destinatario-nova-mensagem" class="validate" type="text" disabled="disabled">
                                    <!--                                    <label class="active">Mensagem para</label> ARRUMAR-->
                                </div>

                                <div class="input-field col s6">
                                    <input id="assunto-nova-mensagem" type="text" class="validate" name="assunto">
                                    <label for="assunto-nova-mensagem">Assunto</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="msg" id="mensagem" class="materialize-textarea" length="500"></textarea>
                                    <label for="mensagem">Sua mensagem</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field col s6">
                                    <input class="file-path validate" type="text">
                                    <div class="btn">
                                        <span>Mídia</span>
                                        <input type="file" name="midia">
                                    </div>
                                </div>
                                <div class="file-field input-field col s6">
                                    <input class="file-path validate" type="text">
                                    <div class="btn">
                                        <span>Documento</span>
                                        <input type="file" name="doc">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!--end container-->

</section>
<!-- END CONTENT --> 
@stop
@include('nav')

