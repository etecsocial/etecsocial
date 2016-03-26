@extends('app')
@section('title')
ETEC Social | Compartilhando conhecimentos
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.min.css',
                        '/css/style-new.css'])->withFullUrl() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery.min.js',
                        '/js/materialize.min.js',
                        '/js/jquery.validate.min.js',
                        '/js/plugins/tokenize/jquery.tokenize.js'])->withFullURL() !!}
<script>
    function turmas() {
        var escola = $('#escola').val();

        if (escola) {
            var url = '/ajax/cadastro/turmas?escola=' + escola;
            $.get(url, function (dataReturn) {
                $('#loadturmas').html(dataReturn);
                $('#loadturmas').material_select();
                $('.caret').hide();
            });
        }
    }
</script>
@stop

@section('content')
@include('home.nav')
<div id="index">
   <div class="section no-pad-bot">
      <div class="container">
         <br><br>
         <h1 class="header center red-text text-darken-2 hide-on-med-and-down">Entre na rede com seus amigos!</h1>
         <div class="row center">
            <h5 class="header col s12 red-text">Compartilhe conhecimentos juntos e desafie seus amigos!</h5>
         </div>
         <div class="row center">
            <a href="{{ url('/login') }}" id="entrar-button" class="btn-large waves-effect waves-light red lighten-1 modal-trigger">Entrar</a>
            <a href="{{ url('/register') }}" id="cadastrar-button" class="btn-large waves-effect waves-light red darken-2 modal-trigger">Cadastrar-se</a>
         </div>
      </div>
   </div>
</div>
<div class="container" id="site-features">
   <div class="section">
      <div class="row">
         <div class="col s12 m4">
            <div class="icon-block">
               <h2 class="center red-text"><i class="material-icons">flash_on</i></h2>
               <h5 class="center">Grupos de Estudos</h5>
               <p class="text-justify">Ao se aproximar da semana de provas, alunos poderão criar grupos de estudo sobre determinada disciplina. Tal grupo terá um local que sugerirá fontes de estudo sobre a matéria, além de ser possível realizar desafios aos membros destes grupos.</p>
            </div>
         </div>
         <div class="col s12 m4">
            <div class="icon-block">
               <h2 class="center red-text"><i class="material-icons">group</i></h2>
               <h5 class="center">Agenda de Estudos</h5>
               <p class="text-justify">A Agenda de estudos será uma ferramenta que possibilitará o agendamento de provas, trabalhos e apresentações tanto pelo professor quanto pelo aluno. O sistema então irá sugerir a criação de grupos de estudos para auxiliar o aluno.</p>
            </div>
         </div>
         <div class="col s12 m4">
            <div class="icon-block">
               <h2 class="center red-text"><i class="material-icons">settings</i></h2>
               <h5 class="center">Desafios</h5>
               <p class="text-justify">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container">
   <div class="section">
      <div class="row">
         <div class="col s12 ">
            <div class="video-container">
               <iframe width="1280" height="720" src="https://www.youtube.com/embed/pAfiLcMJ7q8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
         </div>
      </div>
   </div>
</div>
@include('home.footer')
{!! Form::open() !!}
<input type="hidden" name="type" value="login">
<div id="entrar" class="modal">
   <div class="modal-content">
      <div class="row">
         <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="email" name="email" type="email" class="validate" required>
            <label for="email">Email</label>
         </div>
         <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="senha" name="senha" type="password" class="validate" required>
            <label for="senha">Senha</label>
         </div>
         <div class="col s12">
            <input type="checkbox" id="remember" class="filled-in" name="remember" checked><label for="remember">Manter conectado(a)</label>
            |  <a data-toggle="modal" href="#!">Perdi minha senha</a>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <input type="submit" class="btn-flat red white-text" value="Entrar">
      <a href="#!" class="waves-effect waves-green btn-flat blue white-text">Entrar com facebook</a>
   </div>
</div>
{!! Form::close() !!}
{!! Form::open() !!}
<input type="hidden" name="type" value="cadastro">
<div id="cadastrar" class="modal modal-fixed-footer">
   <div class="modal-content">
      <h4>Cadastrar Aluno</h4>
      <div class="row">
         <div class="input-field col l6 s12">
            <input id="nome" name="nome" type="text" class="validate" required>
            <label for="nome">Nome Completo</label>
         </div>
         <div class="input-field col l6 s12">
            <input id="email" name="email" type="email" class="validate" required>
            <label for="email">Email</label>
         </div>
         <div class="input-field col l6 s12">
            <input id="senha" name="senha" type="password" class="validate" required>
            <label for="senha">Senha</label>
         </div>
         <div class="input-field col l6 s12">
            <select name="escola" id="escola" onchange="turmas()" required>
               <option value="" disabled selected>Selecione sua ETEC</option>
               @foreach(App\Escola::get() as $escola)
               <option value="{{ $escola->id_etec }}">{{ $escola->nome }}</option>
               @endforeach
            </select>
            <label>Escola</label>
         </div>
         <div class="input-field col l6 s12">
            <select name="turma" id="loadturmas" required>
               <option value="" disabled selected>Selecione sua ETEC primeiro</option>
            </select>
            <label>Turma</label>
         </div>
         <div class="input-field col l6 s12">
            <select name="modulo" required>
               <option value="" disabled selected>Selecione o ano/modulo</option>
               @foreach(App\Modulo::get() as $modulo)
               <option value="{{ $modulo->id }}">{{ $modulo->modulo }}º</option>
               @endforeach
            </select>
            <label>Ano/módulo</label>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <input type="submit" class="waves-effect waves-green btn-flat red white-text" value="Cadastrar">
   </div>
</div>
{!! Form::close() !!}
@stop