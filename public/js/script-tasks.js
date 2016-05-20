$("#task-add-button").click(function () {
    $("#task-add").toggle("slow", function () {});
});
function moretask() {
    var task_id = $(".tarefa:last").data("id");
    var task_data = $(".tarefa:last").data("date");
    $.post("/ajax/moretask", {
        id: task_id,
        data: task_data
    }, function (data) {
        if (data === '') {
            $('#loader-tarefa').empty();
            loader = false;
        } else {
            $(data).insertAfter(".tarefa:last").hide().fadeIn(1000);
        }
    });
}

var loader = true;
$(window).scroll(function () {
    if (loader) {
        if ($(window).scrollTop() === $(document).height() - $(window).height()) {
            $('#loader-tarefa').show();
            moretask();
        }
    }
});
$('#salvar-task').ajaxForm({
    dataType: 'JSON',
    success: function (data) {
        if (data.data == 'invalid') {
            Materialize.toast('<span>Ops! Ainda não podemos voltar no tempo! Selecione uma data válida.</span>', 3000);
            exit();
        }

        if (!data.exists) {
            $('#semTarefas').hide(200);
            Materialize.toast('<span>Tarefa adicionada!</span>', 3000);
            var html = '<li class="tarefa collection-item dismissable">' +
                    '<input type="checkbox" id="' + data.id + '" onclick="javascript: checkTask(' + data.id + ')">' +
                    '<label for="' + data.id + '">' + data.desc + '<a href="#" class="secondary-content"><span class="ultra-small">' + data.cont + '</span></a>' +
                    '</label>' +
                    '<span class="task-cat blue darken-3">' + data.data + '</span>' +
                    '</li>';
            $(html).insertBefore(".tarefa:first").hide().fadeIn(2000);
            $("#salvar-task")[0].reset();
        } else {
            Materialize.toast('<span>Parece que você já tem algo parecido com isso para fazer...</span>', 3000);
        }
    },
    error: function () {
        Materialize.toast('<span>Ops... Algo está errado!</span>', 3000);
    }
});
