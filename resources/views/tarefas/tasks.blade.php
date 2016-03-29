@extends('app')

@section('title')
Tarefas | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/asset.css',
                        '/css/style.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
                        '/js/plugins/lightbox-plus-jquery.min.js',
                        '/js/materialize.js',
                        '/js/form.min.js',
                        '/js/script.js',
                        '/js/plugins.js']) !!}
<script>
    $("#task-add-button").click(function() {
    $("#task-add").toggle("slow", function() {});
});

function moretask() {
    var task_id = $(".tarefa:last").data("id");
    var task_data = $(".tarefa:last").data("date");
    $.post("/ajax/moretask", {
        id: task_id,
        data: task_data
    }, function(data) {
        if (data === '') {
            $('#loader-tarefa').empty();
            loader = false;
        } else {
            $(data).insertAfter(".tarefa:last").hide().fadeIn(1000);
        }
    });
}

var loader = true;
$(window).scroll(function() {
    if (loader) {
        if ($(window).scrollTop() === $(document).height() - $(window).height()) {
            $('#loader-tarefa').show();
            moretask();
        }
    }
});
$('#salvar-task').ajaxForm({
    dataType: 'JSON',
    success: function(data) {
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
    error: function() {
        Materialize.toast('<span>Ops... Algo está errado!</span>', 3000);
    }
});

$(document).ready(function() {
    // $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()
});
</script>
@stop
@section('content')
@include('nav')
<section id="content">
   <div class="container">
      <div class="section">
         <div class="col s12">
            <ul id="task-card" class="collection with-header col s12">
               <li class="collection-header cyan">
                  <h4 class="task-card-title">Minhas Tarefas</h4>
                  <p class="task-card-date">
                     {{ \Carbon\Carbon::now()->formatLocalized('%A %d %B %Y') }}
                  </p>
               </li>
               <li class="collection-header" id="task-add" style="display: none;background: #f4f4f4">
                  <h4 class="task-card-title color-sec-text">Nova Tarefa</h4>
                  <div class="row">
                     <form class="col s12" method="POST" action="{{ url('ajax/tarefas') }}" id="salvar-task">
                        <div class="row">
                           <div class="input-field col s6">
                              <i class="material-icons prefix color-sec-text">done_all</i>
                              <input id="icon_prefix" name="desc" type="text" class="validate" placeholder="O que você tem que fazer?" required>
                           </div>
                           <div class="input-field col s6">
                              <i class="material-icons prefix color-sec-text">event</i>
                              <input type="date" id="datepicker" placeholder="Data" name="data">
                           </div>
                        </div>
                        <button type="submit" class="waves-effect wafgves-light btn right color-sec-light">Adicionar</button>
                     </form>
                  </div>
               </li>
               <a class="task-add btn-floating waves-effect waves-light color-sec-darken" id="task-add-button"><i class="mdi-content-add"></i></a>
               @foreach($tasks as $task)
               <li class=" col s6 tarefa collection-item dismissable" data-id="{{ $task->id }}" data-date="{{ $task->data }}">
                  @if($task->checked)
                  <input type="checkbox" id="{{ $task->id }}" checked="checked" onclick="javascript:checkTask('{{ $task->id }}')">
                  @else
                  <input type="checkbox" id="{{ $task->id }}" onclick="javascript:checkTask('{{ $task->id }}')">
                  @endif
                  <label for="{{ $task->id }}">{{ $task->desc }}<a class="secondary-content"><span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp($task->data)->diffForHumans()  }}</span></a>
                  </label>
                  @if($task->data > time() + 3*24*60*60)
                  <span class="task-cat green darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                  @elseif($task->data > time())
                  <span class="task-cat yellow darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                  @else
                  <span class="task-cat red darken-3">{{ \Carbon\Carbon::createFromTimeStamp($task->data)->format("d/m/Y") }}</span>
                  @endif
               </li>
               @endforeach
               @if(empty($tasks))
               <li class="tarefa collection-item dismissable" id="semTarefas">
                  <label for="semTarefas">Você não possui nenhuma tarefa. Clique no Botão + para adicionar!
                  </label>
               </li>
               @else
               <div class="row" id="loader-tarefa" style="display:none;margin-bottom:10px">
                  <div class="col s12 m4 center" style="margin-top: 30px">
                  </div>
                  <div class="col s12 m4 center">
                     <div class="preloader-wrapper big active" style="margin-top: 30px">
                        <div class="spinner-layer spinner-blue-only">
                           <div class="circle-clipper left">
                              <div class="circle"></div>
                           </div>
                           <div class="gap-patch">
                              <div class="circle"></div>
                           </div>
                           <div class="circle-clipper right">
                              <div class="circle"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @endif
            </ul>
         </div>
      </div>
   </div>
   </div>
</section>
@include('footer')
@stop
