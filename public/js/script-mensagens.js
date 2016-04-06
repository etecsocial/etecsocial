/* 
 ...
 */
var erro_interno = '<span>Ops... Algo deu errado, recarregue a página e tente novamente!</span>';

//NOVA MENSAGEM
function novaMensagem(id_dest, nome_dest) {
    $("#nova-mensagem").attr({"action": "/ajax/mensagem/store"});
    $("#id_dest").attr({"value": id_dest});
    $("#destinatario-nova-mensagem").attr({"value": nome_dest});
    $('#modal-nova-mensagem').openModal();
}

////////////////////////////////////////////////////////////////////
//NOVA MENSAGEM
$('#nova-mensagem').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.status === true) {
            $('#modal-nova-mensagem').closeModal();
            Materialize.toast('<span>Mensagem enviada!</span>', 3000);
            $('#nova-mensagem').resetForm();
            $('#qtd-msgs-' + data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
            if (!data.last_msg === false) {//Há mensagens anteriores a que foi excluida.
                $('#qtd-msgs-' + data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
                if (data.is_rem === true) {//O usuário atual é o remetente da última mensagem válida
                    $('#last-msg-' + data.id_user).html('<b>Você: </b>' + data.last_msg).hide().fadeIn(300);
                } else {//O usuário atual é o destinatário da última mensagem válida
                    $('#last-msg-' + data.id_user).html(data.last_msg).hide().fadeIn(300);

                    //Aqui a função getConversa() tem que ser chamada, mas não está funcionando...
                    getConversa(data.id_user, false);
                }
            } else {//a excluida foi a ultima da conversa
                $('.email-reply').html(
                        '<div class="container"><div class="collection"><div class="collection-item">' +
                        'Não há mensagens neste tópico!' +
                        '</div></div></div>').hide().fadeIn(300);
                $('#last-msg-' + data.id_user).html(
                        '<p class="truncate grey-text ultra-small" onclick="javascript: novaMensagem(' + data.id_user + ', \'' + data.nome_user + '\')">' +
                        'Clique para enviar uma mensagem' +
                        '</p>').hide().fadeIn(300);
            }
        } else {
            if (data.status === false) {
                Materialize.toast('<span>Ops, parece que você se esqueceu de algo...</span>', 3000);
            } else {
                Materialize.toast(erro_interno, 3000);
                $('#modal-nova-mensagem').closeModal();
            }
        }
    }
});

////////////////////////////////////////////////////////////////////
//DELETA CONVERSAS ARQUIVADAS
function delConversa() {
    var uid = $('#del').val();
    if ($('#del').hasClass('delConversaArquivada')) {
        $.ajax({
            type: "POST",
            url: "/ajax/mensagem/delConversaArquivada",
            data: "uid=" + uid,
            dataType: "json",
            success: function (data) {
                if (data.status === true) {
                    getConversaArchives(uid, 0);
                    $('#li-' + uid).fadeOut(300).remove();
                    Materialize.toast('Toda as mensagens deste tópico foram apagadas', 5000);
                }
            },
            error: function (data) {
                Materialize.toast(erro_interno, 5000);
            }
        });
    } else {
        if ($('#del').hasClass('delConversa')) {
            $.ajax({
                type: "POST",
                url: "/ajax/mensagem/delConversa",
                data: "uid=" + uid,
                dataType: "json",
                success: function (data) {
                    if (data.status === true) {
                        getConversa(uid, 0);
                        $('#qtd-msgs-' + uid).html('Sem mensagens').hide().fadeIn(300);
                        $('#last-msg-' + uid).html(
                                '<p class="truncate grey-text ultra-small" onclick="javascript: novaMensagem(' + uid + ', \'' + data.nome_user + '\')">' +
                                'Clique para enviar uma mensagem' +
                                '</p>').hide().fadeIn(300);
                        Materialize.toast('Toda as mensagens deste tópico foram apagadas', 5000);
                    }
                },
                error: function (data) {
                    Materialize.toast(erro_interno, 5000);
                }
            });
        } else {
            Materialize.toast('<span>Selecione uma conversa para apagar</span>', 5000);
        }
    }
}

////////////////////////////////////////////////////////////////////
//GET CONVERSAS
function getConversa(uid, nome) {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getConversa",
        data: "id_user=" + uid,
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-details').html(data.responseText);
                if (nome !== 0) {
                    $('#title-msg-details').html('Conversa com ' + nome);
                }
                $('.tooltipped').tooltip();
                $('#icon-coord').removeClass('active');
                $('#delConversa').attr({value: uid})
                $('#del').removeClass('delConversaArquivada').addClass('delConversa').attr({value: uid})
                $('.user').removeClass('selected');
                $('#li-'+uid).addClass('selected');
                $("#nova-mensagem").attr({"action": "/ajax/mensagem/store"});
                $("#id_dest").attr({"value": uid});
                $("#destinatario-nova-mensagem").attr({"value": nome});
                $('#newMsg').attr({value: uid})
                //  $('#email-details').scrollTop();

                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
    return false;
}
////////////////////////////////////////////////////////////////////
//GET CONVERSAS ARQUIVADAS
function getConversaArchives(uid, nome) {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getConversaArchives",
        data: "id_user=" + uid,
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-details').html(data.responseText);
                if (nome !== 0) {
                    $('#title-msg-details').html('Conversa com ' + nome);
                }
                $('.tooltipped').tooltip();
                $('#icon-coord').removeClass('active');
                $('#del').removeClass('delConversa').addClass('delConversaArquivada').attr({value: uid})

                $("#nova-mensagem").attr({"action": "/ajax/mensagem/store"});
                $("#id_dest").attr({"value": uid});
                $("#destinatario-nova-mensagem").attr({"value": nome});
                $('#newMsg').attr({value: uid})

                //  $('#email-details').scrollTop();

                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
    return false;
}

$('#get-users-recents').click(function () {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getUsersRecents",
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-list').html(data.responseText);
                $('#title-msg-list').html('Mensagens recentes');
                $('.tooltipped').tooltip();
                $('.icon-nav-list').removeClass('active');
                $('.get-users-recents').addClass('active');
                //  $('#email-details').scrollTop();

                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
});


$('#get-users-archives').click(function () {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getUsersArchives",
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-list').html(data.responseText);
                $('#title-msg-list').html('Mensagens Arquivadas');
                $('.tooltipped').tooltip();
                $('.icon-nav-list').removeClass('active');
                $('.get-users-archives').addClass('active');
                //  $('#email-details').scrollTop();

               
            }
        }

    });
});
$('#newMsg').click(function () {
    var uid = $('#newMsg').val();
    if (uid) {
        $('#modal-nova-mensagem').openModal();
    } else {
        Materialize.toast('<span>Selecione um usuário para enviar uma nova mensagem.</span>', 5000);
    }
});

$('#get-users-friends').click(function () {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getUsersFriends",
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-list').html(data.responseText);
                $('#title-msg-list').html('Todos os contatos');
                $('.tooltipped').tooltip();
                $('.icon-nav-list').removeClass('active');
                $('.get-users-friends').addClass('active');
                //  $('#email-details').scrollTop();

                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
});

$('#get-users-unread').click(function () {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getUsersUnreads",
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-list').html(data.responseText);
                $('#title-msg-list').html('Mensagens não lidas');
                $('.tooltipped').tooltip();
                $('.icon-nav-list').removeClass('active');
                $('.get-users-unread').addClass('active');
                //  $('#email-details').scrollTop();

                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
});

function arquivarMensagem(id) {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/arquivarMensagem",
        data: "id=" + id,
        dataType: "json",
        success: function (data) {
            $('#mensagem-' + id).fadeOut(300);
            Materialize.toast('Mensagem arquivada.', 5000);
            getUsersArchives();

        },
        error: function () {
            Materialize.toast(erro_interno, 5000);
        }
    });
}
function desarquivarMensagem(id) {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/desarquivarMensagem",
        data: "id=" + id,
        dataType: "json",
        success: function (data) {
            $('#mensagem-' + id).fadeOut(300);
            Materialize.toast('Mensagem removida deste tópico.', 5000);
            getUsersArchives();

        },
        error: function () {
            Materialize.toast(erro_interno, 5000);
        }
    });
}

function getUsersArchives() {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/getUsersArchives",
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast(erro_interno, 5000);
                return false
            } else {
                $('#email-list').html(data.responseText);
                $('#title-msg-list').html('Mensagens Arquivadas');
                $('.tooltipped').tooltip();
                $('.icon-nav-list').removeClass('active');
                $('.get-users-archives').addClass('active');
            }
        }

    });
}



////////////////////////////////////////////////////////////////////
//APAGAR MENSAGENS
function delMensagem(id) {
    $.ajax({
        type: "POST",
        url: "/ajax/mensagem/delMensagem",
        data: "id=" + id,
        dataType: "json",
        success: function (data) {
            if (data.status === true) {//Mensagem deletada
                $('#mensagem-' + id).fadeOut(300);
                if (!data.last_msg === false) {
                    $('#qtd-msgs-' + data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
                    if (data.is_rem === true) {
                        $('#last-msg-' + data.id_user).html('<b>Você: </b>' + data.last_msg).hide().fadeIn(300);
                    } else {
                        $('#last-msg-' + data.id_user).html(data.last_msg).hide().fadeIn(300);
                    }
                } else {//a excluida foi a ultima da conversa
                    $('.email-reply').html(
                            '<div class="container"><div class="collection"><div class="collection-item">' +
                            'Não há mensagens neste tópico!' +
                            '</div></div></div>').hide().fadeIn(300);
                    $('#last-msg-' + data.id_user).html(
                            '<p class="truncate grey-text ultra-small" onclick="javascript: novaMensagem(' + data.id_user + ', \'' + data.nome_user + '\')">' +
                            'Clique para enviar uma mensagem' +
                            '</p>').hide().fadeIn(300);
                    $('#qtd-msgs-' + data.id_user).html('Sem mensagens').hide().fadeIn(300);
                    //
                }
            } else {
                Materialize.toast('A mensagem já havia sido excluida!', 3000);
                $('#mensagem-' + id).fadeOut(300);
            }
        },
        error: function (data) {
            Materialize.toast(erro_interno, 4000);
        }

    });
    return false;
}
////////////////////////////////////////////////////////////////////
