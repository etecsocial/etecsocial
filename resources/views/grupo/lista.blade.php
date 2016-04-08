@extends('app')
@section('title')
Grupos | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
						'/css/materialize.css',
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
    $("#adc-aluno").click(function() {
       $("#adc-aluno-grupo").toggle("fast", function() {

       });
   });

   $("#remove-aluno-dir").click(function() {
       $("#remove-alunos-dir").toggle("fast", function() {

       });
   });


   $("#adc-prof").click(function() {
       $("#adc-profs-grupo").toggle("fast", function() {

       });
   });
   $("#adc-professor-dir").click(function() {
       $("#adc-professores-dir").toggle("fast", function() {

       });
   });

   $("#adc-aluno-dir").click(function() {
       $("#adc-alunos-dir").toggle("fast", function() {

       });
   });

   $("#grupo-remove-aluno").click(function() {
       $("#grupo-remove-alunos").toggle("fast", function() {

       });
   });

   $('#criarGrupo').ajaxForm({
       type: "POST",
       dataType: 'JSON',
       success: function(data) {
           if (data.status) {
               if (data.status == 1) {
                   Materialize.toast('<span>Grupo criado.</span>', 3000);
                   $('#modalAddGrupo').closeModal();

                   var html = '<li class="grupo-item collection-item avatar">' +
                       '<span class="title"><a href="{{ url('/grupo') }}/' + data.url + '"><strong>' + data.nome +
                       '</strong></a></span><div class="col s12"><p class="ultra-small">Criado agora mesmo</p><p class="ultra-small">Você é administrador</p></div></li>';
                   $(html).insertBefore(".grupo-item:first").hide().fadeIn(300);
                   $(".nenhum-grupo").hide();
                   $('#criarGrupo')[0].reset();

               } else {
                   if (data.status === 4) {
                       Materialize.toast('<span>Os campos "nome", "assunto" e "URL" são necessários para criar o grupo.</span>', 3000);
                   } else {
                       if (data.status === 3) {
                           Materialize.toast('<span>Esta URL já está sendo usada por outro grupo!</span>', 3000);
                       } else {
                           if (data.status === 2) {
                               Materialize.toast('<span>Escolha uma data de expiração válida.</span>', 3000);
                           }
                       }
                   }
               }
           } else {
               Materialize.toast('<span>Ops, parece que estamos com problemas. Recarregue a página e tente novamente.</span>', 3000);
           }
       }
   });
</script>
@stop
@section('content')
@include('nav')
<div id="breadcrumbs-wrapper" class="grey lighten-3">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Grupos</h5>
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Pagina Inicial</a></li>
                    <li class="active">Grupos</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <a style="margin:10px" href="#modalAddGrupo" class="btn-floating btn-small wino waves-effect waves-light cyan darken-2 tooltipped" data-position="right" data-delay="50" data-tooltip="Criar grupo de estudos"><i class="material-icons left">library_add</i></a>
        <div class="col s12">
            <ul class="collection">
                <li class="grupo-item"></li>
                @if(isset($grupos[0]))
                @foreach($grupos as $grupo)
                <li class="grupo-item collection-item avatar">
                    <span class="title"><a href="{{ url('/grupo/' . $grupo->url ) }}"><strong>{{ $grupo->nome }}</strong></a></span>

                    <div class="col s12">
                        <p class="ultra-small">Criado {{ Carbon\Carbon::createFromTimeStamp(strtotime($grupo->created_at))->diffForHumans() }}</p>
                    </div>
                    <div class="col s12">
                        <p class="ultra-small">{{ $grupo->is_admin == 1 ? 'Você é administrador' : ''}}</p>
                        <p class="ultra-small">{{ $grupo->is_banido == 1 ? 'Você foi banido por um administrador, mas ainda pode ver o conteúdo publicado por você' : ''}}</p>
                    </div>
                </li>
                @endforeach
                @else
                <div class="col s12 nenhum-grupo">
                    <p>Ops, você não está participando de nenhum grupo.</p>
                </div>
                @endif
            </ul>
            </div>
        </div>
    </div>
</div>
</section>
@include('footer')

<form method="post" id="criarGrupo" action="{{ url('ajax/grupo/criar')}}">
    <div id="modalAddGrupo" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Criar Grupo de Estudos</h4>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field col l6 s12">
                        <input name="nome" id="nome-grupo" type="text" class="validate" length="25" required>
                        <label>Nome</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input name="assunto" id="assunto-grupo" type="text" class="validate" length="30" required>
                        <label>Assunto</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col l6 s12">
                        <input name="url" id="url-grupo" type="text" class="validate tooltipped" length="35" placeholder="etecsocial.com/grupo/" data-position="bottom" data-delay="50" data-tooltip="Como as pessoas irão acessar o grupo.">
                        <label class="active">URL</label>
                    </div>
                    <div class="input-field col l6 s12">
                        <input name="expiracao" id="expiracao-grupo" type="date" data-position="bottom" data-delay="50" data-tooltip="O grupo é para um evento específico ou permanente?.">
                        <label class="active">Expiração</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col l6 s12">
                        <input name="materia" id="materia-grupo" type="text" class="validate tooltipped" length="45" placeholder="Ex.: Matemática" data-position="bottom" data-delay="50" data-tooltip="Caso não, deixe este campo em branco.">
                        <label class="active">O grupo de estudos é para alguma matéria específica?</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer color-sec">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </div>
</form>
@stop