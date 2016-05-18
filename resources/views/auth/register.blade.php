@extends('app')
@section('title')
Cadastro | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.min.css'])->withFullUrl() !!}
@stop

@section('jscript')
<script>
   function turmas() {
       var escola = $('#id_escola').val();
       if(escola == null){
          escola = 1;
       }
   
       if (escola) {
           var url = '/ajax/cadastro/turmas?escola=' + escola;
           $.get(url, function (dataReturn) {
               $('#loadturmas').html(dataReturn);
               $('#loadturmas').material_select();
               $('.caret').hide();
           });
       }
   }

   $(document).ready(function(){
    @if (old('tipo') == 1)
      $('.aluno').show();
      $('.professor').hide();
    @else
      $('.aluno').hide();
      $('.professor').show();
    @endif
      
   });

   $('#register-aluno').click(function(){
      $('.professor').hide();
      $('.aluno').show();
   });

   $('#register-professor').click(function(){
      $('.aluno').hide();
      $('.professor').show();
   });
</script>
@stop
@section('content')
@include('home.nav')
<style>
   #register-page {
   display: table;
   margin: auto;
   vertical-align: middle;
   }
</style>
<div class="container">
   <div id="register-page" class="row">
      <div class="col s12 card-panel center">
            <div class="row">
               <div class="input-field col s12 center">
                  <img src="{{ url('/images/logo.png') }}" alt="ETEC Social" width=250>
               </div>
            </div>
            <div class="row margin">
              <a class="waves-effect waves-light btn-large red darken-1" id="register-aluno"><i class="material-icons left">person_pin</i>Aluno</a>
              <a class="waves-effect waves-light btn-large blue darken-1" id="register-professor"><i class="material-icons left">work</i>Professor</a>              
            </div>
         @include('auth.register.aluno')
         @include('auth.register.professor')
      </div>
   </div>
</div>
@include('home.footer')
@endsection