@extends('app')
@section('title')
Login | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.min.css',
                        '/css/style-new.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery.min.js',
                        '/js/materialize.min.js',
                        '/js/jquery.validate.min.js',
                        '/js/plugins/tokenize/jquery.tokenize.js'])->withFullURL() !!}
@stop

@section('content')
@include('home.nav')
<div class="container">
<div id="login-page" class="row">
    <div class="col s6 card-panel">
        <form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <div class="row">
          <div class="input-field col s12 center">
            <img src="{{ url('/images/logo.png') }}" alt="" width=250>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}" required>
                <label for="email">Email</label>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <div class="input-field col s12">
                <i class="material-icons prefix">vpn_key</i>
                <input id="password" name="password" type="password" class="validate" required  alue="{{ old('password') }}">
                <label for="password">Senha</label>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
        </div>
        </div>
        <div class="row">          
          <div class="input-field col s12">
                <input type="checkbox" id="remember" class="filled-in" name="remember" checked>
                <label for="remember">Manter conectado(a)</label>
                |  <a href="{{ url('/password/reset') }}">Perdi minha senha</a>
            </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button class="btn waves-effect waves-light" type="submit">Logar</button>
            <a class="waves-effect waves-green btn-flat blue white-text">Facebook</a>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a href="{{ url('/register') }}">Cadastrar agora!</a></p>
          </div>         
        </div>
      </form>
    </div>
  </div>
</div></div>
@include('home.footer')
@endsection