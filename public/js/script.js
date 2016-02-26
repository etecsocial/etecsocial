//EDIT PERFIL
$('#edit-perfil').ajaxForm({
type: "POST",
        dataType: 'JSON',
        success: function (data) {
        if (data.response == 1) {
        Materialize.toast('<span>Agradeçemos pelo parecer!</span>', 3000);
        if(data.tipo == 'discussao'){
        $('#discussao-' + data.id).fadeOut(1000, function () {
                this.remove();
                });
            }else{
                if(data.tipo == 'pergunta'){
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


//CHAT
function abrirChat(id_user) {
    $("#id-chat").val(id_user);

    $.post("/ajax/chat/abrir", {id_user: id_user}, function (data) {
        $("#msgs").html(data);
    });

    $("#msgs").animate({scrollTop: $('#msgs').prop("scrollHeight")}, 500);
}

function enviarMsg() {
    var msg = $("#chat-message").val();
    var id = $("#id-chat").val();

    if (msg !== '') {
        $.post("/ajax/chat/enviar", {id: id, msg: msg});
    }
}

//PESQUISA

$("body").click(function () {
    $("#results-search").fadeOut(150);
});

function buscar(busca) {
    $("#results-search").show(function () {
        $("#results-search").fadeIn(2000);
    });

    $.get("/ajax/buscar?termo=" + busca, function (data) {
        $(".busca").html(data);
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
                        .html("<p class='left' style='margin-top:15px'>" + data.status + "</p>")
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
        }
    },
    error: function (data) {
        Materialize.toast('<span>Erro ao editar conta</span>', 3000);
    }
});

//ADICIONAR

function add(id_user) {
    $.ajax({
        type: "POST",
        url: "ajax/adicionar",
        data: "id=" + id_user,
        dataType: "json",
        success: function (data) {
            if (data.status == 'disable') {
                $(".add-icon").attr({"data-tooltip": "Aguardando resposta a solicitação de amizade"});
                $(".add").removeClass("cyan").addClass("grey");
                Materialize.toast('<span>Você enviou uma solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'cancel') {
                $(".add-icon").attr({"class": "mdi-social-person-add", "data-tooltip": "Amizade desfeita com sucesso"});
                $(".add").removeClass("grey").addClass("cyan");
                Materialize.toast('<span>Você cancelou sua solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'enable') {
                $(".add-icon").attr({"data-tooltip": "Enviar solicitação de amizade"});
                $(".add").removeClass("grey").addClass("cyan");
                Materialize.toast('<span>Você cancelou sua solicitação de amizade</span>', 3000);
            } else
            if (data.status == 'success') {
                $(".add").removeClass("red").addClass("cyan");
                $(".add-icon").attr({"class": "mdi-social-people", "data-tooltip": "Vocês são amigos"});
                $(".ami-" + id_user).fadeOut(1000);

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

function recusar(id_user) {
    $.ajax({
        type: "POST",
        url: "ajax/recusar",
        data: "id=" + id_user,
        dataType: "json",
        success: function () {
            $(".add-icon").attr({"data-tooltip": "Enviar solicitação de amizade"});
            $(".add").removeClass("grey").addClass("cyan");
            $(".ami-" + id_user).fadeOut(1000);

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

    $.post("/ajax/notificacao/new", {data: data}, function (data) {
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

var evento = true;

$(function () {
    function longPoll(num) {
        var data = $(".nota:first").data("date");

        if (evento) {
            num = $("#num").data("num");
        }
        
        if (data == null) {
            data = 0;
        }

        $.post('/ajax/notificacao/channel', {data: data, num: num}, function (data) {
            $(".noti").html(data);

            evento = false;
            longPoll(data);
        });
    }
    
    longPoll();
});

//TAREFA

function checkTask(id) {
    $.post("/ajax/tarefas/check", {id: id}, function (data) {
        if (data.status) {
            $(".tar-" + id).attr({"checked": "true"});
        } else {
            $(".tar-" + id).attr({"checked": "false"});
        }
    });
}

//AGENDA

$('#addevento').ajaxForm({
    dataType: 'JSON',
    success: function (data) {

        Materialize.toast('<span>Evento adicionado com sucesso</span>', 3000);
        $('#calendar').fullCalendar('refetchEvents');

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
$('.wino').leanModal({dismissible: true, opacity: .5, in_duration: 500, out_duration: 200});

//LIGHTBOX
lightbox.option({'resizeDuration': 200, 'wrapAround': true});
 