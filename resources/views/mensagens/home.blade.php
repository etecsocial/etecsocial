@extends('app')

@section('title')
Mensagens | ETEC Social
@stop

@section('style')
{!! Html::style('css/font.css') !!}
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
                                    <li><a href="#!" class="email-type">Primary</a>
                                    </li>
                                    <li class="right"><a href="#!"><i class="mdi-action-search"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s12 m7 l7 hide-on-med-and-down">
                                <ul class="right">
                                    <li><a href="#!"><i class="mdi-content-archive"></i></a>
                                    </li>
                                    <li onclick="delConversa($('#id_'))"><a><i class="mdi-action-delete"></i></a>
                                    </li>
                                    <li><a href="#!"><i class="mdi-content-mail"></i></a>
                                    </li>
                                    <li><a href="#!"><i class="mdi-navigation-more-vert"></i></a>
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
                                <img src="{{ App\User::myAvatar() }}" alt="" class="circle responsive-img valign profile-image">
                            </li>
                            <li><a href="#!"><i class="mdi-social-group active"></i></a></li>
                            <li><a href="#!"><i class="mdi-social-group"></i></a></li>
                            <li><a href="#!"><i class="mdi-maps-local-offer"></i></a></li>
                            <li><a href="#!"><i class="mdi-alert-error"></i></a></li>
                        </ul>
                    </div>
                    <div id="email-list" class="col s10 m4 l4 card-panel z-depth-1">
                        <ul class="collection">
                            @foreach($users as $user)
                            <li class="collection-item avatar" onclick="getConversa({{ $user->id }})" id="li-{{$user->id}}">
                                <span class="circle red lighten-1">{{$user->nome[0]}}</span>
          <!--                      <img src="" alt="" class="circle">-->
                                <span class="email-title">{{ $user->nome }}</span>
                                @if($last_msg == $user->id)
                                <p class="truncate grey-text ultra-small">
                                    @if( ($last_msg->id_remetente) == (Auth::user()->id))
                                    <b> Você: </b> 
                                    @endif
                                    {{ $last_msg->msg }}
                                </p>
                                <a href="#!" class="secondary-content email-time"><span class="blue-text ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($last->created_at))->diffForHumans() }}</span></a>
                                @else
                                <p class="truncate grey-text ultra-small" onclick="javascript: novaMensagem({{Auth::user()->id}}, {{$user->id}}, '{{\App\User::verUser($user->id)->nome}}')">
                                    Nova mensagem
                                    @endif
                            </li>
                            @endforeach
                        </ul>
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
                        
                        <div class="email-reply">
                            <div class="row">
                                <div class="col s4 m4 l4 center-align">
                                    <a href="!#"><i class="mdi-content-reply"></i></a>
                                    <p class="ultra-small">Reply</p>
                                </div>
                                <div class="col s4 m4 l4 center-align">
                                    <a href="!#"><i class="mdi-content-reply-all"></i></a>
                                    <p class="ultra-small">Reply all</p>
                                </div>
                                <div class="col s4 m4 l4 center-align">
                                    <a href="!#"><i class="mdi-content-forward"></i></a>
                                    <p class="ultra-small">Forward</p>
                                </div>
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
                                    <li><a href="#!"><i class="mdi-editor-attach-file"></i></a>
                                    </li>
                                    <li><i class="modal-action modal-close  mdi-content-send"></i>
                                    </li>
                                    <li><a href="#!"><i class="mdi-navigation-more-vert"></i></a>
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
                                <div class="input-field col s12">
                                    <input id="destinatario-nova-mensagem" class="validate" type="text" disabled="disabled">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
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
                            <button type="submit" class="btn-info">ENVIAR</button>
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

