<script>
function newpost() {
    var post_id = $(".post:first").data("idpost");
    var user_id = {{$user->id}};
    $.post("/ajax/perfil/newpost", {
        post_id: post_id,
        user_id: user_id
    }, function(data) {
        $(data).insertBefore(".post:first").hide().fadeIn(2000);
    });
}

function morepost() {
    var post_id = $(".post:last").data("idpost");
    var n = $(".post").length;
    var user_id = {{$user->id}};
    $.post("/ajax/perfil/morepost", {
        post_id: post_id,
        user_id: user_id,
        tamanho: n
    }, function(data) {
        if (data === '') {
            $('#loader-post').empty();
            loader = false;
        } else {
            $(data).insertAfter(".post:last").hide().fadeIn(1000);
        }
    });
}

var loader = true;
$(window).scroll(function() {
    if (loader) {
        if ($(window).scrollTop() === $(document).height() - $(window).height()) {
            $('#loader-post').show();
            morepost();
        }
    }

});
$('#publicar').ajaxForm({
    dataType: 'JSON',
    success: function(data) {
        Materialize.toast('<span>Publicado com sucesso!</span>', 3000);
        $('#publicar')[0].reset();
        return newpost();
    },
    error: function(xhr) {
        Materialize.toast('<span>Escreva algo para publicar...</span>', 3000);
    }
});

function comentar(post_id) {
    var elem = "#comentarios-" + post_id;
    var comentario = document.getElementById("comentario-" + post_id).value;
    var comentario_id = $(".com-" + post_id + ":last").data("idpost");
    $.ajax({
        type: "POST",
        url: "/ajax/comentario",
        data: "post_id=" + post_id + "&comentario_id=" + comentario_id + "&comentario=" + comentario,
        dataType: "json",
        success: function(data) {
            $(elem).append(data.responseText);
            $("#comentario-" + post_id).val('');
            /* if (data.num === 1) {
             $("#coment-" + post_id).attr({"data-tooltip": data.num + " pessoa comentou"});
             } else {
             $("#coment-" + post_id).attr({"data-tooltip": data.num + " pessoas comentaram"});
             } */
        }
    });
    return false;
}

function favoritar(post_id) {
    var elem = "#favoritar-" + post_id;
    $.ajax({
        type: "POST",
        url: "/ajax/post/favoritar",
        data: "post_id=" + post_id,
        dataType: "json",
        success: function(data) {
            if (data.status) {
                if (data.num === 0) {
                    $(elem).removeClass("red").addClass("grey").attr({
                        "data-tooltip": "Você favoritou"
                    });
                } else {
                    $(elem).removeClass("red").addClass("grey").attr({
                        "data-tooltip": "Você e outras " + data.num + " pessoas favoritaram"
                    });
                }
            } else {
                $(elem).removeClass("grey").addClass("red").attr({
                    "data-tooltip": data.num + " pessoas favoritaram"
                });
            }
        }
    });
    return false;
}

function repost(post_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/repost",
        data: "post_id=" + post_id,
        dataType: "json",
        success: function(data) {
            Materialize.toast('Conteúdo compartilhado com sucesso.', 5000);
            newpost();
            if (data.num === 1) {
                $("#repost-" + post_id).attr({
                    "data-tooltip": data.num + " pessoa compartilhou"
                });
            } else {
                $("#repost-" + post_id).attr({
                    "data-tooltip": data.num + " pessoas compartilharam"
                });
            }
        }
    });
    return false;
}

function excluir(post_id) {
    $("#excluir").attr({
        "action": "post/" + post_id
    });
}

$('#excluir').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function(data) {
        if (data.status) {
            $('*[data-id="' + data.id + '"]').fadeOut(1000, function() {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Erro ao excluir publicação</span>', 3000);
        }
    }
});

function excluirComentario(comentario_id) {
    $("#excluirComentario").attr({
        "action": "/ajax/comentario/" + comentario_id
    });
}

$('#excluirComentario').ajaxForm({
    type: "DELETE",
    dataType: 'JSON',
    success: function(data) {
        if (data.status) {
            $('#com-' + data.id).fadeOut(1000, function() {
                this.remove();
            });
        } else {
            Materialize.toast('<span>Erro ao excluir comentário</span>', 3000);
        }
    }
});
</script>