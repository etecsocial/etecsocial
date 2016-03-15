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


//COMENTÁRIOS POST FEED
//Comentários
function comentar(id_post) {
    var elem = "#comentarios-" + id_post;
    var id_comentario = $(".com-" + id_post + ":last").data("id");
    var comentario = document.getElementById("comentario-" + id_post).value;
    $.ajax({
        type: "POST",
        url: "/ajax/comentario",
        data: "id_post=" + id_post + "&id_comentario=" + id_comentario + "&comentario=" + comentario,
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast('Digite algo para comentar.', 5000);
                return false
            } else {
                $(elem).append(data.responseText);
                $("#comentario-" + id_post).val('');
            }
        }
    });
    return false;
}
////////////////////////////////////////////////////////////////////

//Edição de comentários
function exibeEditarComentario(id_comentario, comentario) {

    $('#com-' + id_comentario + '-text').html(
            '<form id="alterar-comentario-' + id_comentario + '" action="ajax/comentario/editar/post" method="POST">' +
            '<input name="novo_comentario" id="com-editing-' + id_comentario + '" type="text" class="validate" autocomplete="off" value="' + comentario + '">' +
            '<input name="id_comentario" id="com-editing-' + id_comentario + '" type="hidden" value="' + id_comentario + '">' +
            '</form>');
    $('#alterar-comentario-' + id_comentario).ajaxForm({
        dataType: 'JSON',
        success: function (data) {
            $('#com-' + id_comentario + '-text').html(data.comentario)
        },
        error: function (xhr) {
            Materialize.toast('<span>Não foi possível comentar neste post! Faça login para continuar.</span>', 5000)
            window.location.href = "etec.localhost/"
            $('#com-' + id_comentario + '-text').html(comentario)
        }

    });
}
////////////////////////////////////////////////////////////////////////////////

//Excluir
function excluirComentario(id_comentario) {
    $("#excluirComentario").attr({"action": "/ajax/comentario/" + id_comentario});
}
$('#excluirComentario').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            $('#com-' + data.id).fadeOut(1000, function () {
                this.remove();
            });
        } else {
            if (data.status == 3) {
                $('#com-' + data.id).fadeOut(1000, function () {
                    this.remove();
                });
                 Materialize.toast('<span>O comentário já havia sido excluido!</span>', 3000);
            }
           
        }

    },
    error: function (data) {
        Materialize.toast('<span>Erro ao excluir comentário</span>' + data, 3000);
    }
});
////////////////////////////////////////////////////////////////////////////////

//UP/DOWN
function comentarioRel(id, id_post, rel) {
    $.ajax({
        type: "POST",
        url: "/ajax/comentario/relevancia/post",
        data: "id_comentario=" + id + "&rel=" + rel + "&id_post=" + id_post,
        dataType: "json",
        success: function (data) {
            if (rel === 'up') {
                $('#relevancia-com-' + id).html('<i class="mdi-hardware-keyboard-arrow-up right small-photo" style="color: #039be5"></i>' +
                        '<i onclick="comentarioRel(' + id + ', ' + id_post + ', '+'\'down\''+')" class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #ccc; cursor: pointer"></i>');
            } else {
                $('#relevancia-com-' + id).html('<i onclick="comentarioRel(' + id + ', ' + id_post + ', '+'\'up\''+')" class="mdi-hardware-keyboard-arrow-up right small-photo" style="color: #ccc; cursor: pointer"></i>' +
                        '<i class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #039be5"></i>');
            }
        },
        error: function (){
            Materialize.toast('Estamos com problemas com isso no momento, tente novamente mais tarde.', 3000);
        }
    });
}
////////////////////////////////////////////////////////////////////////////////

//FAVORITAR
function favoritar(id_post) {
    var elem = "#favoritar-" + id_post;
    $.ajax({
        type: "POST",
        url: "/ajax/post/favoritar",
        data: "id_post=" + id_post,
        dataType: "json",
        success: function (data) {
            if (data.status) {
                if (data.num === 0) {
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você favoritou"});
                } else {
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você e outras " + data.num + " pessoas favoritaram"});
                }
            } else {
                $(elem).removeClass("grey")
                        .addClass("red")
                        .attr({"data-tooltip": data.num + " pessoas favoritaram"});
            }
        }
    });
    return false;
}
////////////////////////////////////////////////////////////////////////////////

//REPOST
function repost(id_post) {
    $.ajax({
        type: "POST",
        url: "/ajax/repost",
        data: "id_post=" + id_post,
        dataType: "json",
        success: function (data) {
            Materialize.toast('Conteúdo compartilhado com sucesso.', 5000);
            newpost();
            if (data.num === 1) {
                $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoa compartilhou"});
            } else {
                $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoas compartilharam"});
            }
        }
    });
    return false;
}
////////////////////////////////////////////////////////////////////////////////

//EXCLUIR POST
function excluir(id_post) {
    $("#excluir").attr({"action": "/ajax/post/" + id_post});
}

$('#excluir').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function (data) {
        if (data.status) {
            $('*[data-id="' + data.id + '"]').fadeOut(1000, function () {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Erro ao excluir publicação</span>', 3000);
        }
    }
});
////////////////////////////////////////////////////////////////////////////////

//NEWPOST
function newpost() {
    var post_id = $(".post:first").data("id");
    $.post("/ajax/newpost", {id: post_id}, function (data) {
        $(data).insertBefore(".post:first").hide().fadeIn(2000);
    });
}
///////////////////////////////////////////////////////////////////////////////

//MOREPOST
function morepost() {
    var post_id = $(".post:last").data("id");
    var n = $(".post").length;
    $.post("/ajax/morepost", {id: post_id, tamanho: n}, function (data) {
        if (data === '') {
            $('#loader-post').empty();
            loader = false;
        } else {
            $(data).insertAfter(".post:last").hide().fadeIn(1000);
        }
    });
}

var loader = true;
$(window).scroll(function () {
    if (loader) {
        if ($(window).scrollTop() === $(document).height() - $(window).height()) {
            $('#loader-post').show();
            morepost();
        }
    }
});
$('#publicar').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        Materialize.toast('<span>Publicado com sucesso!</span>', 3000);
        $('#publicar')[0].reset();
        return newpost();
    },
    error: function (xhr) {
        Materialize.toast('<span>Escreva algo para publicar...</span>', 3000);
    }
});
////////////////////////////////////////////////////////////////////////////////