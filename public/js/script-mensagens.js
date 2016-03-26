/* 
 Scripts de funcionamento de recursos essenciais, abaixo lista na ordem em que são posicionados
 
 ->Comentários
 -Comentar
 -Editar
 -Excluir
 -Up/Down
 ->Publicação
 -Favoritar
 -Repost
 ->
 ->
 ->
 */
var erro_interno = '<span>Ops... Algo deu errado, recarregue a página e tente novamente!</span>';

//NOVA MENSAGEM
function novaMensagem(id_dest, nome_dest) {
    $("#nova-mensagem").attr({"action": "/ajax/mensagem/store"});
    $("#id_dest").attr({"value": id_dest});
    $("#destinatario-nova-mensagem").attr({"value": nome_dest});
    $('#modal-nova-mensagem').openModal();
}

$('#nova-mensagem').ajaxForm({
    type: "POST",
    dataType: 'JSON',
    success: function (data) {
        if (data.status === true) {
            $('#modal-nova-mensagem').closeModal();
            Materialize.toast('<span>Mensagem enviada!</span>', 3000);
            $('#qtd-msgs-'+data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
            if (!data.last_msg === false) {//Há mensagens anteriores a que foi excluida.
                $('#qtd-msgs-'+data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
                if (data.is_rem === true) {//O usuário atual é o remetente da última mensagem válida
                    $('#last-msg-' + data.id_user).html('<b>Você: </b>' + data.last_msg).hide().fadeIn(300);
                } else {//O usuário atual é o destinatário da última mensagem válida
                    $('#last-msg-' + data.id_user).html(data.last_msg).hide().fadeIn(300);
                    
                    //Aqui a função getConversa() tem que ser chamada, mas não está funcionando...
                    getConversa(data.id_user);
                }
            } else {//a excluida foi a ultima da conversa
                $('.email-reply').html(
                        '<div class="container"><div class="collection"><div class="collection-item">' +
                        'Não há mensagens neste tópico!' +
                        '</div></div></div>').hide().fadeIn(300);
                $('#last-msg-' + data.id_user).html(
                        '<p class="truncate grey-text ultra-small" onclick="javascript: novaMensagem(' + data.auth_id + ', ' + data.id_user + ', \'' + data.nome_user + '\')">' +
                        'Clique para enviar uma mensagem' +
                        '</p>').hide().fadeIn(300);
            }
        } else {
            Materialize.toast(erro_interno, 3000);
            $('#modal-nova-mensagem').closeModal();
        }
    }
});
////////////////////////////////////////////////////////////////////
//GET CONVERSAS
function getConversa(uid) {
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
                //$('#li-'+uid).addClass('active'); resolver, na deixa ativo certo
            }
        }

    });
    return false;
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
                    $('#qtd-msgs-'+data.id_user).html(data.qtd_msgs).hide().fadeIn(300);
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
                    $('#qtd-msgs-'+data.id_user).html('Sem mensagens').hide().fadeIn(300);
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
