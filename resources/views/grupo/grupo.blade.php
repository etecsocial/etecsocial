@extends('app')

@section('title')
{{ $grupo->nome }} - ETEC Social
@stop

@section('style')
<link href="{{ env('ASSETS') }}/css/asset.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="{{ env('ASSETS') }}/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<style>.chip{display:inline-block;height:32px;font-size:13px;font-weight:500;color:rgba(0,0,0,.6);line-height:32px;padding:0 12px;border-radius:16px;background-color:#e4e4e4}.chip img{float:left;margin:0 8px 0 -12px;height:32px;width:32px;border-radius:50%}.chip i.material-icons{cursor:pointer;float:right;font-size:16px;line-height:32px;padding-left:8px}</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="screen,projection">
@stop

@section('jscript')
<script type="text/javascript" src="{{ env('ASSETS') }}/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/materialize.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/form.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/sliders.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins/succinct-master/jQuery.succinct.min.js"></script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/jquery.tagsinput.min.js"></script>
@if(isset($integranteEu->is_admin))
<script>$("#modalAnalisarDenunciaGrupo").length&&$("#modalAnalisarDenunciaGrupo").openModal({dismissible:!0,opacity:.5,in_duration:1e3,out_duration:500});</script>
@endif
<script>
    $("#adc-aluno").click(function() {
        $("#adc-aluno-grupo").toggle("fast");
    });

    $("#remove-aluno-dir").click(function() {
        $("#remove-alunos-dir").toggle("fast");
    });
        
    $("#adc-prof").click(function() {
        $("#adc-profs-grupo").toggle("fast");
    });
    $("#adc-professor-dir").click(function() {
        $("#adc-professores-dir").toggle("fast");
    });
    
    $("#adc-aluno-dir").click(function() {
        $("#adc-alunos-dir").toggle("fast");
    });

    $("#grupo-remove-aluno").click(function() {
        $("#grupo-remove-alunos").toggle("fast");
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
</script>
<script type="text/javascript" src="{{ env('ASSETS') }}/js/plugins.js"></script>
<script>
function denunciaGrupo(id_pub, tipo_pub, id_autor_pub) {
    $("#id_pub").val(id_pub);
    $("#tipo_pub").val(tipo_pub);
    $("#id_autor_pub").val(id_autor_pub);
}

$('#denunciaGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.response == 1) {
            Materialize.toast('<span>Sua denúncia foi registrada. Em breve o administrador de grupo será notificado.</span>', 3000);
        } else {
            if (data.response == 3) {
                Materialize.toast('<span>Já há uma denúncia referente a esta publicação registrada.</span>', 3000);
            } else {
                Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
            }
        }
    }
});

$('#analisaDnunciaGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.response == 1) {
            Materialize.toast('<span>Agradeçemos pelo parecer!</span>', 3000);
            if (data.tipo == 'discussao') {
                $('#discussao-' + data.id).fadeOut(1000, function () {
                    this.remove();
                });
            } else {
                if (data.tipo == 'pergunta') {
                    $('#pergunta-' + data.id).fadeOut(1000, function () {
                        this.remove();
                    });
                }
            }
        } else {
            Materialize.toast('<span>Não conseguimos fazer isso no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

function addAlunoGrupoDireto(amigo_id, grupo_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/grupo/addAlunoDir",
        data: "id_grupo=" + grupo_id + "&id_amigo=" + amigo_id,
        dataType: "json",
        success: function (data) {
            if (data.response == 1) {
                $('#group-alone').fadeOut(500);
                $('#alunos-add-rec').fadeIn(1000);
                $('#grupo-amigo-dir-' + amigo_id).appendTo("#alunos-add-rec");
                $('#grupo-amigo-dir-' + amigo_id).hide().fadeIn(1000);
                return false
            } else {
                if (data.response == 3) {
                    $('#grupo-amigo-dir-' + amigo_id).fadeOut(500);
                    Materialize.toast('<span>Ops, parece que este usuário já foi adicionado ao grupo!</span>', 3000);
                    return false
                } else {
                    if (data.response == 2) {
                        $('#grupo-amigo-dir-' + amigo_id).hide();
                        Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
                        return false
                    }
                }
            }
        }
    });
}

function addProfessorGrupoDir(professor_id, grupo_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/grupo/addProfGrupo",
        data: "id_grupo=" + grupo_id + "&id_professor=" + professor_id,
        dataType: "json",
        success: function (data) {
            if (data.response == 1) {
                $('#grupo-professor-dir' + professor_id).fadeOut(1000);
                Materialize.toast('<span>Notificaremos seu convite ao professor.</span>', 3000);
                return false
            } else {
                if (data.response == 3) {
                    Materialize.toast('<span>O professor já foi convidado por outro usuário.</span>', 3000);
                    return false
                }
                Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
            }
        }
    });
}

$('#excluirComentarioDiscussao').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            $('#com-disc-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Não conseguimos excluir isso no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

//EXCLUIR PERGUNTA
function excluirPergunta(id_pergunta) {
    $("#excluirPergunta").attr({"action": "/ajax/grupo/pergunta/delete"});
    $("#id_pergunta_excluir").val(id_pergunta);
}

//EXCLUIR DISCUSSAO
function excluirDiscussao(id_discussao) {
    $("#excluirDiscussao").attr({"action": "/ajax/grupo/discussao/delete"});
    $("#id_discussao_excluir").val(id_discussao);
}

$('#excluirPergunta').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.response == 1) {
            $('#pergunta-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            if (data.response == 3) {
                Materialize.toast('<span>Ops, parece que esta pergunta já foi excluida!</span>', 3000);
                return false
            } else {
                if (data.response == 2) {
                    Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
                    return false
                } else {
                    Materialize.toast('<span>' + data.request + '</span>', 3000);
                }
            }
        }
    }
});

$('#excluirDiscussao').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.response == 1) {
            $('#discussao-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            if (data.response == 3) {
                Materialize.toast('<span>Ops, parece que esta discussão já foi excluida!</span>', 3000);
                return false
            } else {
                if (data.response == 2) {
                    Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
                    return false
                } else {
                    Materialize.toast('<span>' + data.request + '</span>', 3000);
                }
            }
        }
    }
});

function removeAlunoGrupo(id_aluno, grupo_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/grupo/removeAlunoGrupo",
        data: "id_grupo=" + grupo_id + "&id_aluno=" + id_aluno,
        dataType: "json",
        success: function (data) {
            if (data.response === 1) {
                Materialize.toast('<span>O usuário foi banido. Suas publicações ainda serão visíveis até que ele ou você as exclua.</span>', 4000);
                $('#aluno-int-1-' + id_aluno).fadeOut(1000);
                $('#aluno-int-2-' + id_aluno).fadeOut(1000);
                return false
            } else {
                if (data.response === 2) {
                    Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
                } else {
                    Materialize.toast('<span>Este usuário já foi excluído.</span>', 3000);
                }
            }
        }
    });
}

function addAlunoGrupo(amigo_id, grupo_id) {
    $("#amigo-" + amigo_id).appendTo("#amigos-add");
    $("#amigo-" + amigo_id).addClass("amigo-add-grupo");
    $("#input-amigo-" + amigo_id).appendTo("#amigos-add");
    $("#input-amigo-" + amigo_id).addClass("amigo-add-grupo-input");
}

$(".amigo-add-grupo").click(function () {
    $(this).removeClass("amigo-add-grupo");
    $(this).appendTo("#amigos-grupo");
    $(this).removeClass("amigo-add-grupo-input");
    $(this).appendTo("#grupo-inputs-amigo");
});

$('#excluirGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            Materialize.toast('<span>Grupo excluído.</span>', 3000);
        } else {
            Materialize.toast('<span>Não conseguimos excluir isso no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

$('#criarGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            if (data.status === 1) {
                Materialize.toast('<span>Grupo criado.</span>', 3000);
            } else {
                if (data.status == 3) {
                    Materialize.toast('<span>Esta URL já está sendo utilizada por outro grupo.</span>', 3000);
                } else {
                    Materialize.toast('<span>Não foi possível criar o grupo no momento... Atualize a página e tente novamente.</span>', 3000);
                }
            }
        } else {
            Materialize.toast('<span>Não foi possível criar o grupo no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

$('#editGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            if (data.status === 1) {
                Materialize.toast('<span>Alterações salvas.</span>', 3000);
                $('#modalAddGrupo').closeModal();
            } else {
                if (data.status == 3) {
                    Materialize.toast('<span>Esta URL já está sendo utilizada por outro grupo.</span>', 3000);
                } else {
                    Materialize.toast('<span>Não foi possível salvar as alterações... Atualize a página e tente novamente.</span>', 3000);
                }
            }
        } else {
            Materialize.toast('<span>Não foi possível salvar as alterações... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

function discutir(id_discussao) {
    var elem = "#com-disc-" + id_discussao;
    var id_comentario = $(".com-disc-" + id_discussao + ":last").data("id");
    var comentario = document.getElementById("comentario-" + id_discussao).value;
    $.ajax({
        type: "POST",
        url: "/ajax/discussao",
        data: "id_discussao=" + id_discussao + "&id_comentario=" + id_comentario + "&comentario=" + comentario + "&id_grupo=" + {{ $grupo->id }},
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
        data: "id_pergunta=" + id_pergunta + "&id_comentario=" + id_comentario + "&comentario=" + comentario + "&id_grupo=" + {{ $grupo->id }},
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

function excluirComentarioDiscussao(id_comentario) {
    $("#excluirComentarioDiscussao").attr({"action": "/ajax/discussao/" + id_comentario});
}

$('#excluirComentarioDiscussao').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            $('#com-disc-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Não conseguimos excluir isso no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

$('.wino').leanModal({dismissible: true, opacity: .5, in_duration: 500, out_duration: 200});

function newpost() {
    var id_post = $(".post:first").data("id");
    $.post("perfil/newpost", {id_post: id_post, id_user: id_user}, function (data) {
        $(data).insertBefore(".post:first").hide().fadeIn(2000);
    });
}

function excluirComentarioPergunta(id_comentario) {
    $("#excluirComentarioPergunta").attr({"action": "/ajax/pergunta/" + id_comentario});
}

function newDiscussao() {
    var discussao_id = $(".discussao:first").data("id");
    $.post("/ajax/grupo/newDiscussao", {id: discussao_id}, function (data) {
        $(data).insertBefore(".discussao:first").hide().fadeIn(2000);
    });
}

$('#excluirComentarioPergunta').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            $('#com-perg-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Não conseguimos excluir isso no momento... Atualize a página e tente novamente.</span>', 3000);
        }
    }
});

$('#sairGrupo').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.response) {
            Materialize.toast('<span>Você não está mais neste grupo!</span>', 3000);
        } else {
            Materialize.toast('<span>Ops, estamos um pouco confusos... Atualize a página e tente novamente!</span>', 3000);
        }
    }
});

$('#publicarDiscussao').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        Materialize.toast('<span>Você iniciou uma discussão, aguarde seus amigos participarem!</span>', 3000);
        $('#publicarDiscussao')[0].reset();
        newDiscussao()

    },
    error: function (data, xhr) {
        Materialize.toast('<span>Os campos "assunto" e "discussão" são obrigatórios.</span>', 3000);
    }
});

$('#publicarPergunta').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        Materialize.toast('<span>Você fez uma pergunta! Notificaremos você caso alguém a responda.</span>', 3000);
        $('#publicarPergunta')[0].reset();
        return novapergunta();
    },
    error: function (data, xhr) {
        Materialize.toast('<span>O campo "Pergunta" é obrigatório.</span>', 3000);
    }
});

$('#publicarMaterial').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        if (data.response == 1) {
            Materialize.toast('<span>O material foi adicionado, esperamos que seja útil para seus amigos!</span>', 3000);
            $('#PublicarMaterial')[0].reset();
        } else {
            if (data.response == 3) {
                Materialize.toast('<span>Selecione um documento para enviar!</span>', 3000);
                $('#PublicarMaterial')[0].reset();
            } else {
                if (data.response == 4) {
                    Materialize.toast('<span>O arquivo enviado não é um documento aceito.</span>', 3000);
                    $('#PublicarMaterial')[0].reset();
                }
                Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
            }
        }
    },
    error: function (data, xhr) {
        Materialize.toast('<span>Ops, estamos confusos... Atualize a página e tente novamente.</span>', 3000);
    }
});
</script>
@stop

@section('content')

@include('navFull')

<!-- START CONTENT -->
<section id="content">

    <!--start container-->
    <div class="container">

        <div id="profile-page" class="section">
            <!-- profile-page-header -->
            <div id="profile-page-header" class="card">
                <div class="card-image waves-effect waves-block waves-light hide-on-small-and-down">
                    <img class="activator" src="../images/foto-capa.jpg" alt="user background">
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
                                <ul class="tabs tab-profile z-depth-1 color-pri" style="width: 100%;">
                                    <li class="tab col s3" style="width: 33.3333333333333%;"><a class="white-text waves-effect waves-light" href="#discussoes"><i class="mdi-editor-border-color"></i> Discussões</a>
                                    </li>
                                    <li class="tab col s3" style="width: 33.3333333333333%;"><a class="white-text waves-effect waves-light" href="#perguntas"><i class="mdi-communication-live-help"></i> Perguntas</a>
                                    </li>
                                    <li class="tab col s3" style="width: 33.3333333333333%;"><a class="white-text waves-effect waves-light" href="#material"><i class="mdi-social-school"></i> Conteúdo complementar</a>
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

<!--                            <div class="card color-sec">
                                <div class="card-content white-text">
                                    <span class="card-title"> Objetivo do grupo</span>
                                    <blockquote style="border-left-color: #f4f4f4">
                                        <p> dado.intuito</p>
                                        <p> dado.intuito</p>
                                        <p> dado.intuito</p>
                                        <p> dado.intuito</p>
                                        <p> dado.intuito</p>
                                        <p> dado.intuito</p>
                                    </blockquote>
                                </div>
                            </div>-->
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

                                                    <p>Última discussão por <a href="{{url(App\User::verUser($atv[0]-> id_rem)-> username)}}">{{ App\User::verUser($atv[0]->id_rem)->nome }}</a>
                                                        <br> <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($atv[0]->created_at))->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="secondary-content">{{ $grupo->num_discussoes }}</p>
                                                </li>
                                            @endif
                                            @if(isset($atv[1]))
                                                <li class="collection-item avatar">
                                                    <i class="mdi-action-help circle orange"></i>
                                                    <span class="title"><a href="{{url(App\User::verUser($atv[1]-> id_rem)-> username)}}">{{ $atv[1]->id_rem == Auth::User()->id ? 'Você' : App\User::verUser($atv[1]->id_rem)->nome }}</a> perguntou:</span>
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
                                                    <p class="truncate">Último enviado por <a href="{{url(App\User::verUser($atv[1]-> id_rem)-> username)}}">{{ $atv[1]->id_rem == Auth::User()->id ? 'você' : App\User::verUser($atv[1]->id_rem)->nome }}</a>
                                                        <br> <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($atv[2]->created_at))->diffForHumans() }}</span>
                                                    </p>
                                                    <p class="secondary-content">19</p>
                                                </li>
                                            @endif
                                            @if(isset($atv[3]))
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle red">input</i>
                                                    <span class="title"><a href="{{url(App\User::verUser($atv[3]-> id_user)-> username)}}">{{ App\User::verUser($atv[3]->id_user)->nome }}</a> deixou o grupo, pois</span>
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
                                            <div class="col s7 grey-text text-darken-4 right-align">{{ App\User::verUser($grupo->id_criador)->nome }}</div>
                                        </div>
                                    </li>
                                </ul>

                                <!--/  DETALHES DO GRUPO -->


                                <!--TASK CARD-->
                                <ul id="task-card" class="collection with-header">
                                    <li class="collection-header color-pri bg-card-tasks">
                                        <h5 class="task-card-title">Notas do professor</h5>

                                        <p class="task-card-date">Tarefas, avisos ou dicas.</p>

                                    </li>
                                    <div style="max-height: 300px; overflow-y: scroll">
                                        <li class="collection-item dismissable">
                                            <p> Recurso em desenvolvimento.</p>
        <!--                                    <input type="checkbox" id="todo.id" class="cyan">
                                           <label for="todo.id">Recurso indisponível<a href="#" class="secondary-content"><span class="ultra-small">todo.date</span></a>
                                           </label>
                                           <span class="task-cat yellow darken-3">todo.day</span>-->
                                        </li>

                                    </div>
                                    <!--                            <form>
                                                                    <li class="collection-item dismissable">
                                                                        <i class="left mdi-action-assignment"></i>Adicionar objetivo
                                                                        <input placeholder="Seja específico" class="validate" type="text" alt="Digite o objetivo" dir="ltr" autocomplete="off" id="NovoObjetivoGrupo">
                                                                    </li>
                                                                </form>-->
                                </ul>
                                <!--END TASK CARD-->
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


 <!--arrumado teaqu-->


                       @include('grupo.modal')



                    </div>
                </div>
                </section>
                @stop