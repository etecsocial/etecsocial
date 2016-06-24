@extends('base')

@section('title')
{{ $grupo->nome }} - ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.css',
                        '/css/asset.css',
                        '/css/style.css'])->withFullURL() !!}
<style>.chip{display:inline-block;height:32px;font-size:13px;font-weight:500;color:rgba(0,0,0,.6);line-height:32px;padding:0 12px;border-radius:16px;background-color:#e4e4e4}.chip img{float:left;margin:0 8px 0 -12px;height:32px;width:32px;border-radius:50%}.chip i.material-icons{cursor:pointer;float:right;font-size:16px;line-height:32px;padding-left:8px}</style>
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
                        '/js/plugins/lightbox-plus-jquery.min.js',
                        '/materialize-css/js/materialize.min.js',
                        '/js/form.min.js',
                        '/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js',
                        '/js/plugins/fullcalendar/lib/moment.min.js',
                        '/js/plugins/fullcalendar/js/fullcalendar.min.js',
                        '/js/plugins/fullcalendar/fullcalendar-script.js',
                        '/js/plugins/jquery.nanoscroller.min.js',
                        '/js/plugins/sparkline/jquery.sparkline.min.js',
                        '/js/plugins/sparkline/sparkline-script.js',
                        '/js/plugins/succinct-master/jQuery.succinct.min.js',
                        '/js/script.js',
                        '/js/plugins.js',
                        '/js/script-grupo.js']) !!}

@if(isset($integranteEu->is_admin))
<script>$("#modalAnalisarDenunciaGrupo").length&&$("#modalAnalisarDenunciaGrupo").openModal({dismissible:!0,opacity:.5,in_duration:1e3,out_duration:500});</script>
@endif
<script>

            function discutir(id_discussao) {
            var elem = "#com-disc-" + id_discussao;
                    var id_comentario = $(".com-disc-" + id_discussao + ":last").data("id");
                    var comentario = document.getElementById("comentario-" + id_discussao).value;
                    $.ajax({
                    type: "POST",
                            url: "/ajax/discussao",
                            data: "id_discussao=" + id_discussao + "&id_comentario=" + id_comentario + "&comentario=" + comentario + "&id_grupo=" + {{ $grupo -> id }},
                            dataType: "json",
                            error: function (data) {
                            if (data.responseText === "empty") {
                            Materialize.toast('Digite algo para participar a discussão.', 5000);
                                    return false
                            } else {
                            $(elem).append(data.responseText);
                                    $("#comentario-" + id_discussao).val('');
                            }
                            }
                    });
                    return false;
                    }

    function responder(id_pergunta) {
    var elem = "#com-perg-" + id_pergunta;
            var id_comentario = $(".com-perg-" + id_pergunta + ":last").data("id");
            var comentario = document.getElementById("perg-resp-" + id_pergunta).value;
            $.ajax({
            type: "POST",
                    url: "/ajax/pergunta",
                    data: "id_pergunta=" + id_pergunta + "&id_comentario=" + id_comentario + "&comentario=" + comentario + "&id_grupo=" + {{ $grupo -> id }},
                    dataType: "json",
                    error: function (data) {
                    if (data.responseText === "empty") {
                    Materialize.toast('Você não pode publicar uma resposta em branco!', 5000);
                            return false
                    } else {
                    $(elem).append(data.responseText);
                            $("perg-resposta-" + id_pergunta).val('');
                    }
                    }
            });
            return false;
            }
</script>
@stop

@section('content')

@include('nav')

<!-- START CONTENT -->
<section id="content">

    <!--start container-->
    <div class="container">

        <div id="profile-page" class="section">
            <!-- profile-page-header -->
            <div id="profile-page-header" class="card">
                <div class="card-image waves-effect waves-block waves-light hide-on-small-and-down">
                    <img class="activator" src="../images/foto-capa.jpg">
                </div>

                <div class="card-content">
                        <div class="row">
                            <div class="col s3 offset-l2">
                                <h4 class="card-title grey-text text-darken-4">{{ $grupo-> nome}}</h4>
                                <p class="medium-small grey-text" id="desc_grupo">{{ $grupo-> assunto}}</p>
                            </div>
                            
                            <div class="col s2 center-align">
                                
                                @if(!$banido)
                                    <h4 class="card-title grey-text text-darken-4">{{ $grupo-> num_participantes}} </h4> 
                                @else
                                <div class="material-icons" style="margin-top: 30px">lock_outline</div> 
                                @endif
                                
                                <p class="medium-small grey-text" style="margin-top: 5px">Participantes</p>
                            </div>
                            
                             <div class="col s2 center-align">
                                
                                @if(!$banido)
                                    <h4 class="card-title grey-text text-darken-4">{{ $grupo-> num_discussoes}} </h4> 
                                @else 
                                    <div class="material-icons" style="margin-top: 30px">lock_outline</div>
                                @endif
                                
                                <p class="medium-small grey-text" style="margin-top: 5px">Discussões</p>
                            </div>
                            <div class="col s2 center-align">
                                
                                @if(!$banido) 
                                    <h4 class="card-title grey-text text-darken-4">{{ $grupo-> num_perguntas}} </h4> 
                                @else 
                                    <div class="material-icons" style="margin-top: 30px">lock_outline</div> 
                                @endif
                                
                                <p class="medium-small grey-text" style="margin-top: 5px">Perguntas</p>
                            </div>
                            @if(!$banido)
                                <div class="col s1 right-align">
                                        <a href="#{{ isset($integranteEu) ? $integranteEu->is_admin ? 'modalExcluirGrupo' : 'modalSairGrupo' : ''}}" class="modal-trigger tooltipped btn-floating activator waves-effect waves-light color-sec-darken right" data-position="left" data-delay="50" data-tooltip="{{ isset($integranteEu) ? $integranteEu->is_admin ? 'Excluir Grupo' : 'Sair do grupo' : ''}}">
                                        <i class="material-icons" >{{ isset($integranteEu) ? $integranteEu->is_admin ? 'delete' : 'input' : ''}}</i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!--/ profile-page-header -->

                <!-- profile-page-content -->
                <div id="profile-page-content" class="row">
                    <!-- profile-page-wall -->
                    <div id="profile-page-wall" class="col s12 m8">
                        <!-- INICIO TABS SELECT CONTEUDO -->
                        <div id="profile-page-wall-share" class="row">
                            <div class="col s12">
                                <ul class="tabs tab-profile z-depth-1 color-pri">
                                    <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#discussoes"><i class="mdi-editor-border-color"></i> Discussões</a>
                                    </li>
                                    <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#perguntas"><i class="mdi-communication-live-help"></i> Perguntas</a>
                                    </li>
                                    <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#material"><i class="mdi-social-school"></i> Conteúdos</a>
                                    </li>
                                    <div class="indicator" style="right: 471px; left: 0px;"></div>
                                </ul>

                            </div>
                        </div>
                        <!--/ TABS CONTEUDOS -->
                        <!-- profile-page-wall-posts -->
                        <div id="profile-page-wall-posts" class="row">
                            <!-- Discussoes-->
                            @include('grupo.discussoes')
                            <!-- Peegunta -->
                            @include('grupo.perguntas')
                            <!-- Material complementar -->
                            @include('grupo.materiais')
                        </div>
                        <!--/ profile-page-wall-posts -->
                    </div> 
                    <!--/ profile-page-wall -->

                    <!-- profile-page-sidebar-->
                    <div id="profile-page-sidebar" class="col s12 m4">
                        <div>
                            @if((isset($integranteEu->is_admin)) and isset($expirado))
                                <div class="card color-pri-light">
                                    <div class="card-content white-text">
                                        <span class="card-title"><div class="material-icons">info_outline</div> Grupo Expirado</span>
                                        <blockquote style="border-left-color: #f4f4f4">
                                            <p class="ng-binding">A data de expiração do grupo já passou.</p>
                                            <p class="ng-binding">Os usuários ainda poderão visualizar o material publicado, mas não será possível criar novas publicações.</p>
                                            <div class="divider"></div>
                                            <p class="ng-binding ultra-small">Caso ainda não tenha atingio a meta desejada com a criação do grupo, fique à vontade para criar outro!</p>
                                        </blockquote>
                                    </div>
                                </div>
                            @endif

                            <!-- ATIVIDADES DO GRUPO  -->
                            @if(!$banido)
                                @if(!isset($expirado))
                                    @if($integranteEu->is_admin)
                                        <ul id="profile-page-about-feed" class="collection z-depth-1" style="margin-top: 0px">
                                            @if(isset($atv[0]))
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle blue">question_answer</i>
                                                    <span class="title">Discussões recentes no grupo</span>

                                                    <p>Última discussão por <a href="{{url(auth()->user()->verUser($atv[0]-> id_rem)-> username)}}">{{ auth()->user()->verUser($atv[0]->id_rem)->nome }}</a>
                                                        <br> <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($atv[0]->created_at))->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="secondary-content">{{ $grupo->num_discussoes }}</p>
                                                </li>
                                            @endif
                                            @if(isset($atv[1]))
                                                <li class="collection-item avatar">
                                                    <i class="mdi-action-help circle orange"></i>
                                                    <span class="title"><a href="{{url(auth()->user()->verUser($atv[1]-> id_rem)-> username)}}">{{ $atv[1]->id_rem == Auth::User()->id ? 'Você' : auth()->user()->verUser($atv[1]->id_rem)->nome }}</a> perguntou:</span>
                                                    <p class="truncate">"{{ $atv[1]-> desc}}"
                                                        <br> <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($atv[1]->created_at))->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="secondary-content">{{ $grupo-> num_perguntas}}</p>
                                                </li>
                                            @endif
                                            @if(isset($atv[2]))
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle green">description</i>
                                                    <span class="title">Materiais de apoio</span>
                                                    <p class="truncate">Último enviado por <a href="{{url(auth()->user()->verUser($atv[1]-> id_rem)-> username)}}">{{ $atv[1]->id_rem == Auth::User()->id ? 'você' : auth()->user()->verUser($atv[1]->id_rem)->nome }}</a>
                                                        <br> <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($atv[2]->created_at))->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="secondary-content">19</p>
                                                </li>
                                            @endif
                                            @if(isset($atv[3]))
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle red">input</i>
                                                    <span class="title"><a href="{{url(auth()->user()->verUser($atv[3]-> user_id)-> username)}}">{{ auth()->user()->verUser($atv[3]->user_id)->nome }}</a> deixou o grupo, pois</span>
                                                    <p class="truncate">{{ $atv[3]-> motivo}}
                                                        <br> <span class="ultra-small">Achamos que sabendo disso você poderá aprimorar o grupo.</span>
                                                    </p>
                                                </li>
                                            @endif
                                            @if((!isset($atv[0])) and (!isset($atv[1])) and (!isset($atv[2])) and (!isset($atv[3])))
                                            <li class="collection-item avatar">
                                                <i class="material-icons circle blue">question_answer</i>
                                                <span class="title">Novo grupo</span>
                                                <p>Inicie uma discussão, pergunte algo ou convide amigos para entrar!
                                                </p>
                                            </li>
                                            @endif
                                        </ul>
                                    @endif 
                                @endif <!--É ADMINISTRADOR-->
                               
                        
                            <!-- CONFIGURAÇÕES DO GRUPO  -->
                            @include('grupo.configuracoes')
                          
                                <!-- DETALHES DO GRUPO  -->
                                <ul id="profile-page-about-details" class="collection z-depth-1">
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s5 grey-text darken-1"><i class="mdi-action-wallet-travel"></i> Matéria</div>
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ $grupo->materia != '' ? $grupo->materia : 'Não específico' }}</div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s5 grey-text darken-1"><i class="mdi-social-poll"></i> Assunto</div>
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ $grupo-> assunto}}</div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s5 grey-text darken-1"><i class="mdi-social-domain"></i> Criação</div>
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ Carbon\Carbon::createFromTimeStamp(strtotime($grupo->criacao))->diffForHumans() }}</div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s5 grey-text darken-1"><i class="mdi-social-school"></i> Expiração</div>
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ isset($grupo->expiracao) ? Carbon\Carbon::createFromTimeStamp(strtotime($grupo->expiracao))->diffForHumans() : 'Indeterminado' }}</div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s5 grey-text darken-1"><i class="mdi-social-cake"></i> Criador</div>
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ auth()->user()->verUser($grupo->id_criador)->nome }}</div>
                                        </div>
                                    </li>
                                </ul>

                                <!--/  DETALHES DO GRUPO -->

                            @else <!--É BANIDO-->
                            <div class="card color-sec">
                                <div class="card-content white-text">
                                    <span class="card-title"><div class="material-icons">lock_outline</div> Usuário Banido</span>
                                    <blockquote style="border-left-color: #f4f4f4">
                                        <p class="ng-binding">Você foi banido pelo administrador do grupo e não pode mais interagir aqui.</p>
                                        <p class="ng-binding">Ainda é possível visualizar suas publicações e, opcionalmente, excluí-las.</p>
                                        <div class="divider"></div>
                                        <p class="ng-binding ultra-small">A ETEC Social preza pela qualidade do conteúdo das publicações de seus usuários. Esperamos que isso não ocorra novamente.</p>
                                    </blockquote>
                                </div>
                            </div>
                            @endif  <!--É BANIDO-->

                        </div>
                        <!-- profile-page-sidebar-->
                       @include('grupo.modal')
                    </div>
                </div>
                </section>
                @stop