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
            Materialize.toast('<span>Mensagem enviada!</span>', 3000);
        } else {
            Materialize.toast('<span>Ops, algo deu errado! Verifique os campos e tente novamente!</span>', 3000);
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
                Materialize.toast('Digite algo para comentar.', 5000);
                return false
            } else {
                $('#email-details').html(data.responseText);
                //$('#li-'+uid).addClass('active'); resolver
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
            if (data.status === true) {
                $('#mensagem-' + id).fadeOut(300);
                if (!data.last_msg === false) {
                    if (data.is_rem === true) {
                        $('#last-msg-' + data.id_user).html('<b>Você: </b>' + data.last_msg).hide().fadeIn(300);
                    } else {
                        $('#last-msg-' + data.id_user).html(data.last_msg).hide().fadeIn(300);
                    }
                }else{//a excluida foi a ultima da conversa
                    $('#last-msg-' + data.id_user).html('Clique para enviar uma mensagem').hide().fadeIn(300);
                }
            } else {
                Materialize.toast('A mensagem já havia sido excluida!', 3000);
                $('#mensagem-' + id).fadeOut(300);

            }
        },
        error: function (data) {
            Materialize.toast('Ops, estamos confusos! Recarregue a página e tente novamente.', 4000);
        }

    });
    return false;
}
////////////////////////////////////////////////////////////////////
