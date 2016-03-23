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
function novaMensagem(id_rem, id_dest, nome_dest) {
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