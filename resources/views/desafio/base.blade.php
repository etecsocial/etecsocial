@extends('base')
@section('title')
Desafios | ETEC Social
@stop
@section('style')
{!! Minify::stylesheet(['/css/style.css'])->withFullURL() !!}
@stop
@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
'/js/plugins/lightbox-plus-jquery.min.js',
'/materialize-css/js/materialize.min.js',
'/js/form.min.js',
'/js/plugins/jquery.nanoscroller.min.js',
'/js/plugins/sparkline/jquery.sparkline.min.js',
'/js/plugins/sparkline/sparkline-script.js',
'/js/plugins/succinct-master/jQuery.succinct.min.js',
'/js/script.js',
'/js/plugins.js']) !!}
<script>
$(document).ready(function(){
  $('.delete').click(function(event) {
    event.preventDefault();
    var id = this.id;

    $.ajax('{{ url('/desafios/delete') . '/' }}' + id, {
       success: function(data) {
           $("#desafio-" + id).hide();
           Materialize.toast('<span>Desafio excluido com sucesso</span>', 3000);
       },
       error: function() {
           Materialize.toast('<span>Erro ao excluido</span>', 3000);
       }
    });
  });
});
</script>
@stop
@section('content')
@include('partials._nav')
<div id="breadcrumbs-wrapper" class="grey lighten-3">
   <div class="container">
      <div class="row">
         <div class="col s12 m12 l12">
            <h5 class="breadcrumbs-title">Desafios</h5>
            <ol class="breadcrumb">
               <li><a href="{{ url('/') }}">Pagina Inicial</a></li>
               <li class="active">Desafios</li>
            </ol>
         </div>
      </div>
   </div>
</div>
@yield('desafio_content')
@stop
