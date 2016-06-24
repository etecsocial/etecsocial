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
function comentar(post_id) {
    var elem = "#comentarios-" + post_id;
    var comentario_id = $(".com-" + post_id + ":last").data("id");
    var comentario = document.getElementById("comentario-" + post_id).value;
    $.ajax({
        type: "POST",
        url: "/ajax/comentario",
        data: "post_id=" + post_id + "&comentario_id=" + comentario_id + "&comentario=" + comentario,
        dataType: "json",
        error: function (data) {
            if (data.responseText === "empty") {
                Materialize.toast('Digite algo para comentar.', 5000);
                return false
            } else {
                $(elem).append(data.responseText);
                $("#comentario-" + post_id).val('');
            }
        }
    });
    return false;
}
////////////////////////////////////////////////////////////////////

//Edição de comentários
function exibeEditarComentario(comentario_id, comentario) {
    $('#edita-comentario-' + comentario_id).fadeOut();
    $('#com-' + comentario_id + '-text').html(
            '<form id="alterar-comentario-' + comentario_id + '" action="ajax/comentario/editar/post" method="POST">' +
            '<input name="novo_comentario" id="com-editing-' + comentario_id + '" type="text" class="validate" autocomplete="off" value="' + comentario + '">' +
            '<input name="comentario_id" id="com-editing-' + comentario_id + '" type="hidden" value="' + comentario_id + '">' +
            '</form>');
    $('#alterar-comentario-' + comentario_id).ajaxForm({
        dataType: 'JSON',
        success: function (data) {
            if (!data.empty) {
                $('#com-' + comentario_id + '-text').html(data.comentario)
                $('#edita-comentario-' + comentario_id).fadeIn();
            }else{
                Materialize.toast('<span>Digite algo para comentar!</span>', 3000);
            }
        },
        error: function (xhr) {
            Materialize.toast('<span>Não foi possível comentar neste post! Faça login para continuar.</span>', 5000);
            window.location.href = "etec.localhost/";
            $('#com-' + comentario_id + '-text').html(comentario)
        }

    });
}
////////////////////////////////////////////////////////////////////////////////

//Excluir
function excluirComentario(comentario_id) {
    $("#excluirComentario").attr({"action": "/ajax/comentario/" + comentario_id});
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
function comentarioRel(id, post_id, rel) {
    $.ajax({
        type: "POST",
        url: "/ajax/comentario/relevancia/post",
        data: "comentario_id=" + id + "&rel=" + rel + "&post_id=" + post_id,
        dataType: "json",
        success: function (data) {
            if (rel === 'up') {
                $('#relevancia-com-' + id).html('<i class="mdi-hardware-keyboard-arrow-up right small-photo" style="color: #039be5"></i>' +
                        '<i onclick="comentarioRel(' + id + ', ' + post_id + ', ' + '\'down\'' + ')" class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #ccc; cursor: pointer"></i>');
            } else {
                $('#relevancia-com-' + id).html('<i onclick="comentarioRel(' + id + ', ' + post_id + ', ' + '\'up\'' + ')" class="mdi-hardware-keyboard-arrow-up right small-photo" style="color: #ccc; cursor: pointer"></i>' +
                        '<i class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #039be5"></i>');
            }
        },
        error: function () {
            Materialize.toast('Estamos com problemas com isso no momento, tente novamente mais tarde.', 3000);
        }
    });
}
////////////////////////////////////////////////////////////////////////////////

//FAVORITAR
function favoritar(post_id) {
    var elem = "#favoritar-" + post_id;
    $.ajax({
        type: "POST",
        url: "/ajax/post/favoritar",
        data: "post_id=" + post_id,
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
function repost(post_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/repost",
        data: "post_id=" + post_id,
        dataType: "json",
        success: function (data) {
            Materialize.toast('Conteúdo compartilhado com sucesso.', 5000);
            newpost();
            if (data.num === 1) {
                $("#repost-" + post_id).attr({"data-tooltip": data.num + " pessoa compartilhou"});
            } else {
                $("#repost-" + post_id).attr({"data-tooltip": data.num + " pessoas compartilharam"});
            }
        }
    });
    return false;
}
////////////////////////////////////////////////////////////////////////////////

//EXCLUIR POST
function excluir(post_id) {
    $("#excluir").attr({"action": "/ajax/post/" + post_id});
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
        $('#num-posts').html(data.num_posts);
        $('#pontuacao').html(data.pontuacao);
        newpost();
    },
    error: function (xhr) {
        Materialize.toast('<span>Escreva algo para publicar...</span>', 3000);
    }
});
////////////////////////////////////////////////////////////////////////////////