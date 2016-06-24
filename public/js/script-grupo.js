/* 
 Scripts de funcionamento de recursos essenciais, abaixo lista na ordem em que são posicionados
 ->
 ->
 ->
 */
//Edição de comentários
function exibeEditarComentario(id_comentario) {
   
    var comentario = $('#com-'+ id_comentario +'-text').text();
    $('#com-' + id_comentario + '-text').html(
            '<form id="alterar-comentario-' + id_comentario + '" action="http://etec.localhost/ajax/comentario/editar/discussao" method="POST">' +
            '<input name="novo_comentario" id="com-editing-' + id_comentario + '" type="text" class="validate" autocomplete="off" value="' + comentario + '">' +
            '<input name="id_comentario" id="com-editing-' + id_comentario + '" type="hidden" value="' + id_comentario + '">' +
            '</form>');
    $('#alterar-comentario-' + id_comentario).ajaxForm({
        dataType: 'JSON',
        success: function (data) {
            $('#com-' + id_comentario + '-text').html(data.comentario)
        },
        error: function (xhr) {
            Materialize.toast('<span>Não foi possível comentar neste post! Faça login para continuar.</span>', 5000);
            //window.location.href = "etec.localhost/"
            $('#com-' + id_comentario + '-text').html(comentario);
            return false;
        }

    });
}
////////////////////////////////////////////////////////////////////////////////

$("#adc-aluno").click(function () {
    $("#adc-aluno-grupo").toggle("fast");
});

$("#remove-aluno-dir").click(function () {
    $("#remove-alunos-dir").toggle("fast");
});

$("#adc-prof").click(function () {
    $("#adc-profs-grupo").toggle("fast");
});
$("#adc-professor-dir").click(function () {
    $("#adc-professores-dir").toggle("fast");
});

$("#adc-aluno-dir").click(function () {
    $("#adc-alunos-dir").toggle("fast");
});

$("#grupo-remove-aluno").click(function () {
    $("#grupo-remove-alunos").toggle("fast");
});

lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
});
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
            if (data.status == 1) {
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
    $.post("perfil/newpost", {id_post: id_post, user_id: user_id}, function (data) {
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
        if (data.status != 422) {
            Materialize.toast('<span>Confirme suas credenciais na página de login para continuar!</span>', 3000);
        } else {
            Materialize.toast('<span>Os campos "assunto" e "discussão" são obrigatórios.</span>', 3000);
        }
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