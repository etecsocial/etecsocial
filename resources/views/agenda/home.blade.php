@extends('base') 
@section('title') Agenda | ETEC Social @stop

@section('style')
{!! Minify::stylesheet(['/css/style.css',
                        '/js/plugins/fullcalendar/css/fullcalendar.min.css'])->withFullURL() !!}
@stop
@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
                        '/js/plugins/lightbox-plus-jquery.min.js',
                        '/materialize-css/js/materialize.min.js',
                        '/js/form.min.js',
                        '/js/plugins/fullcalendar/lib/jquery-ui.custom.min.js',
                        '/js/plugins/fullcalendar/lib/moment.min.js',
                        '/js/plugins/fullcalendar/js/fullcalendar.min.js',
                        '/js/plugins/fullcalendar/fullcalendar-script.js',
                        '/js/script.js',
                        '/js/plugins.js']) !!}
<script>
   $('#excluir').ajaxForm({
       type: "DELETE",
       dataType: 'JSON',
       success: function (data) {
           if (data.status) {
               $('#calendar').fullCalendar('refetchEvents');
           } else {
               Materialize.toast('<span>Você não pode excluir esse evento</span>', 3000);
           }
       }
   });
</script>
@stop
@section('content') @include('nav')
<div id="breadcrumbs-wrapper" class="grey lighten-3">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Tarefas</h5>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Pagina Inicial</a></li>
                    <li class="active">Tarefas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="section">
        Crie eventos para datas de provas, trabalhos, apresentações, seminários e etc. {{ auth()->user()->type == 1 ? 'Caso queira, crie eventos compartilhados com sua turma!' : 'Professor, lembre-se que você pode adicionar eventos compartilhados com as turmas as quais você leciona!' }}</p>
        <div class="divider"></div>
        <div style="margin-top:10px">
            <a href="#novoevento" class="wino btn waves-effect waves-light cyan darken-2">Adicionar evento</a>
            <div>
                <div id="full-calendar">
                    <div class="col s12 m6 l9">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<div id="evento" class="modal" data-target="evento">
    <div class="modal-content">
        <h4 id="agenda-title"></h4>
        <i id="opcoes" style="display:none">
      <i id="data-opcoes"></i>
        </i>
        <i id="user"></i>
        <p id="agenda-content"></p>
    </div>
    <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-red btn-flat">Fechar</a>
        <form id="excluir" method="DELETE">
            <input type="hidden" id="iduser" value="{{ auth()->user()->id }}">
            <button type="submit" class="modal-action modal-close waves-effect waves-red btn-flat">Excluir</button>
        </form>
    </div>
</div>
@include('footer') @stop
