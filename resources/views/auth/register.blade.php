@extends('app')
@section('title')
Cadastro | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.min.css'])->withFullUrl() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery.min.js',
                        '/js/materialize.min.js'])->withFullURL() !!}}
                      
@section('jscript')
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
         <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
            {!! csrf_field() !!}
            <div class="row">
               <div class="input-field col s12 center">
                  <img src="{{ url('/images/logo.png') }}" alt="" width=250>
               </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 m6 l6">
                   <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                   <label >Nome Completo</label>
                   @if ($errors->has('name'))
                   <span class="help-block">
                   <strong>{{ $errors->first('name') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="input-field col s12 m6 l6">
                   <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                   <label >Usuário</label>
                   @if ($errors->has('username'))
                   <span class="help-block">
                   <strong>{{ $errors->first('username') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="input-field col s12 m6 l6">
                   <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                   <label >Email</label>
                   @if ($errors->has('email'))
                   <span class="help-block">
                   <strong>{{ $errors->first('email') }}</strong>
                   </span>
                   @endif
                </div>

                <div class="input-field col s12 m6 l6">
                    <select name="escola" id="escola" onchange="turmas()" required>
                        <option value="" disabled selected>Selecione sua ETEC</option>
                        @foreach(App\Escola::get() as $escola)
                        <option value="{{ $escola->id_etec }}">{{ $escola->nome }}</option>
                        @endforeach
                    </select>
                    <label>Escola</label>
                </div>

                <div class="input-field col s12 m6 l6">
                    <select name="turma" id="loadturmas" required>
                        <option value="" disabled selected>Selecione sua ETEC primeiro</option>
                    </select>
                    <label>Turma</label>
                </div>

                <div class="input-field col s12 m6 l6">
                    <select name="modulo" required>
                        <option value="" disabled selected>Selecione o ano/modulo</option>
                        @foreach(App\Modulo::get() as $modulo)
                        <option value="{{ $modulo->id }}">{{ $modulo->modulo }}º</option>
                        @endforeach
                    </select>
                    <label>Ano/módulo</label>
                </div>

                <div class="input-field col s12 m6 l6">
                   <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                   <label >Senha</label>
                   @if ($errors->has('password'))
                   <span class="help-block">
                   <strong>{{ $errors->first('password') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="input-field col s12 m6 l6">
                   <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                   <label >Confirmar a senha</label>
                   @if ($errors->has('password_confirmation'))
                   <span class="help-block">
                   <strong>{{ $errors->first('password_confirmation') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="input-field col s12">
                      <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </div>
         </form>
      </div>
   </div>
</div>
@include('home.footer')
@endsection