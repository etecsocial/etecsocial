$(document).ready(function() {
    $('input#cc, textarea#cc').characterCounter();
  });
//EDIT PERFIL
$('#edit-perfil').ajaxForm({
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


function getTurmasProfDisp(escola_id) {
    //pega as turmas da quela escola que o professor ainda nao tenha cadastrado
    if (escola_id) {
        var url = '/ajax/cadastro/getTurmasProfDisp?escola_id=' + escola_id;
        $.get(url, function (dataReturn) {
            $('#loadturmas').html(dataReturn).material_select();
            $('#loadmodulos').html('');
            $('.caret').hide();
        });
    } else {
        Materialize.toast('<span>Escola não selecionada ou inexistente.</span>', 3000);
    }
}


//PROFESSOR
$('#addTurmasProfessor').ajaxForm({
    success: function (data) {
        if (data.status === true) {
            Materialize.toast('<span>Turma cadastrada.</span>', 3000);
            $('#addTurmasProfessor').resetForm();
        }
    },
    error: function (data) {
        Materialize.toast('<span>Existem erros no formulário enviado.</span>', 3000);
    }//@todo exibir corretamente os erros retornados pela validação
});

//COORDENADOR
$('#setTurmasCoordenador').ajaxForm({
    success: function (data) {
        Materialize.toast('<span>Turma cadastrada.</span>', 3000);
        $('#setTurmasCoordenador').resetForm();
    },
    error: function (errors) {
        if (errors) {
            Materialize.toast('<span>Turma já cadastrada.</span>', 3000);
        }

    }//@todo exibir corretamente os erros retornados pela validação
});

$('.done-turmas-coord').click(function () {
    Materialize.toast('<span>Você ainda pode editar as turmas de sua escola no menu "Minha ETEC".</span>', 3000);

    var url = '/ajax/cadastro/doneTurmas';
    $.get(url, function () {
        return true;
    });
});
$('.done-turmas-prof').click(function () {
    Materialize.toast('<span>Você ainda pode editar as turmas que você leciona no menu "Minha ETEC".</span>', 3000);

    var url = '/ajax/cadastro/doneTurmas';
    $.get(url, function () {
        return true;
    });
});

//CHAT
function abrirChat(user_id) {
    $("#id-chat").val(user_id);

    $.post("/ajax/chat/abrir", {
        user_id: user_id
    }, function (data) {
        $("#msgs").html(data);
    });

    $("#msgs").animate({
        scrollTop: $('#msgs').prop("scrollHeight")
    }, 500);
}

function enviarMsg() {
    var msg = $("#chat-message").val();
    var id = $("#id-chat").val();

    if (msg !== '') {
        $.post("/ajax/chat/enviar", {
            id: id,
            msg: msg
        });
    }
}

function fecharChat() {
    $("#id-chat").val('0');
    $("#msgs").html('<br><center><img src="images/loading.gif"></center>');
}

//socket.on("channel:App\\Events\\MensagemChat", function(message){
//if($("#id-chat").val() == message.rem_id) {
//$('<div class="chatn clear"></div><div class="chatm from-them" data-date="' + message.data + '"><img class="circle photo" alt="John Peter" src="' + message.foto_rem + '"> ' + message.msg + ' </div>').insertAfter(".chatn:last").hide().fadeIn(1000);
//} else {
//$('#num_chat').text(parseInt($('#num_chat').text()) + 1);
//}
//});

//PESQUISA
$("body").click(function () {
    $("#results-search").fadeOut(150);
});

function buscar(busca) {
    $("#results-search").show(function () {
        $("#results-search").fadeIn(2000);
    });

    $.ajax({
      url: '/ajax/buscar/' + busca,
      dataType: 'html',
      success: function(data){
            $(".busca").html(data);
      },
      error: function(){
            $(".busca").html('<p>Não foi encontrado nada</p>');
      }
    });
}

//STATUS
$('#status').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        if (data.error) {
            Materialize.toast('<span>' + data.error + '</span>', 3000);
        } else {
            $("#us").fadeOut(250, function () {
                $("#us").fadeIn(250)
                        .html("<a class='left' style='margin-top:15px'>" + data.status + "</a>")
                        .text();
            });
        }
    },
    error: function () {
        Materialize.toast('<span>Erro ao atualizar status</span>', 3000);
    }
});

//CONTA
$('#conta').ajaxForm({
    success: function (data) {
        Materialize.toast('<span>' + data.msg + '</span>', 3000);
        if (data.status) {
            $("#modalConta").closeModal();
            $(".profile-image, .profile-image-post").attr('src', $(".profile-image").attr('src') + '?' + Math.random());
            $(".profile-btn").html($("#nome").val());
        }
    },
    error: function (data) {
        Materialize.toast('<span>Erro ao editar conta</span>', 3000);
    }
});

//ADICIONAR
function add(user_id) {
    $.ajax({
        type: "POST",
        url: "ajax/adicionar",
        data: "id=" + user_id,
        dataType: "json",
        success: function (data) {
            if (data.status == 'disable') {
                $(".add-icon").attr({
                    "data-tooltip": "Aguardando resposta a solicitação de amizade"
                });
                $(".add").removeClass("cyan").addClass("grey");
                Materialize.toast('<span>Você enviou uma solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'cancel') {
                $(".add-icon").attr({
                    "class": "mdi-social-person-add",
                    "data-tooltip": "Amizade desfeita com sucesso"
                });
                $(".add").removeClass("grey").addClass("cyan");
                Materialize.toast('<span>Você cancelou sua solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'enable') {
                $(".add-icon").attr({
                    "data-tooltip": "Enviar solicitação de amizade"
                });
                $(".add").removeClass("grey").addClass("cyan");
                Materialize.toast('<span>Você cancelou sua solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'success') {
                $(".add").removeClass("red").addClass("cyan");
                $(".add-icon").attr({
                    "class": "mdi-social-people",
                    "data-tooltip": "Vocês são amigos"
                });
                $(".ami-" + user_id).fadeOut(1000);

                $(".amc").html($("#solic li").length - 1);

                if ($("#solic li").length === 1) {
                    $("#tarefas").html("<p>Solicitações de Amizade</p><p>Não há novas solicitações de amizade.</p>");
                }

                Materialize.toast('<span>Você aceitou essa solicitação de amizade</span>', 3000);
            }
        }
    });
    return false;
}

//RECUSAR
function recusar(user_id) {
    $.ajax({
        type: "POST",
        url: "ajax/recusar",
        data: "id=" + user_id,
        dataType: "json",
        success: function () {
            $(".add-icon").attr({
                "data-tooltip": "Enviar solicitação de amizade"
            });
            $(".add").removeClass("grey").addClass("cyan");
            $(".ami-" + user_id).fadeOut(1000);

            if ($("#solic li").length === 1) {
                $("#tarefas").html("<p>Solicitações de Amizade</p><p>Não há novas solicitações de amizade.</p>");
            }

            Materialize.toast('<span>Você recusou essa solicitação de amizade</span>', 3000);

        }
    });
    return false;
}

//NOTIFICACAO
function newnoti() {
    var data = $(".nota:first").data("date");

    $.post("/ajax/notificacao/new", {
        data: data
    }, function (data) {
        if (data !== '') {
            $(data).insertBefore(".nota:first").hide().fadeIn(2000);
        }

    });
}

function read() {
    $.ajax({
        type: "GET",
        url: "ajax/notificacao/makeread",
        success: function () {
            $(".new").remove();
            $(".noti").html("0");
        }
    });
    return false;
}

//socket.on("channel:App\\Events\\Notificacao", function(message){
//$('#num_not').text(parseInt($('#num_not').text()) + parseInt(message.num));
//});

//TAREFA
function checkTask(id) {
    $.post("/ajax/tarefas/check", {
        id: id
    }, function (data) {
        if (data.status) {
            $(".tar-" + id).attr({
                "checked": "true"
            });
        } else {
            $(".tar-" + id).attr({
                "checked": "false"
            });
        }
    });
}

//AGENDA
$('#addevento').ajaxForm({
    dataType: 'JSON',
    success: function (data) {

        Materialize.toast('<span>Evento adicionado com sucesso</span>', 3000);
        $('#calendar').fullCalendar('refetchEvents');
        $("#addevento")[0].reset();
    },
    error: function () {
        Materialize.toast('<span>Erro ao adicionar evento</span>', 3000);
    },
});

$('input[type=radio][name=tipo]').change(function () {
    if ($(this).val() == 1) {
        $('#fim').show();
        $('#inicio').html("Início");
    } else {
        $('#fim').hide();
        $('#inicio').html("Data");
    }
});

$('input[type=radio][name=publico]').change(function () {
    if ($(this).val() == 1) {
        $('.addturma').show();
    } else {
        $('.addturma').hide();
    }
});

//POST
function abrirPost(id) {
    $.get('/ajax/post/' + id, function (data) {
        $("#modalpost").html(data);
        $("#verpost").openModal();
    });

    window.history.pushState("object", "ETEC Social", "/post/" + id);
}

//MODAL
$('.wino').leanModal({
    dismissible: true,
    opacity: .5,
    in_duration: 500,
    out_duration: 200
});

//LIGHTBOX
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
});
